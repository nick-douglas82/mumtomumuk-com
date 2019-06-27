<?php

namespace App\Importer;

use App\Category;
use App\Tag;
use App\Directory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait Importer
{
    /**
     * Set the storage path for images
     * @var string
     */
    protected $storagePath = 'public/flexible_content/post_id_';

    public function importPosts()
    {
        $this->page = (! $this->page) ? '&page=1': '&page=' . $this->page;

        $posts = collect($this->getJson($this->url . $this->type . "/?_embed&filter[orderby]=modified" . $this->page));

        $this->apiPosts[] = $posts->pluck('id')->toArray();

        // If result does not come back with false.
        if ($posts[0] != false) {
            $this->sync($posts);
        }
        else {
            $apiPosts = array_map('array_filter', $this->apiPosts);
            $apiPosts = collect(array_filter($apiPosts))->flatten();

            $this->checkForUnsyncedPosts($apiPosts);
        }
    }

    protected function sync($posts)
    {

        foreach ($posts as $post) {
            $this->syncPost($post);
        }

        $this->page = (int)str_replace("&page=", '', $this->page);

        $this->page = $this->page + 1;
        return $this->importPosts();
    }


    public function getAuthor($data)
    {
        $author = collect($data)->last();
        return $author->id;
    }

    public function getArrayFromObj($object)
    {
        if ($object) {
            $array = [];
            foreach ($object as $obj) {
                $array[] = (array) $obj;
            }

            return $array;
        }
    }

    public function getGalleryImages($post, $images)
    {

        if (empty($images)) {
            return;
        }

        collect($images)->each(function ($image, $key) use ($post) {
            $post->addMediaFromUrl($image->url)
                 ->usingName('gallery_image')
                 ->toMediaCollection('gallery');
        });
    }

    function buildContentArray($post, $data)
    {
        return serialize(collect($data->acf->content)->map(function ($value) use ($post, $data) {

            return ( $value->acf_fc_layout === 'image_and_text' ) ? $this->storeImage($data, $value, false) : '';
            return ( $value->acf_fc_layout === 'image_only' ) ? $this->storeImage($data, $value, true) : '';
            return ( $value->acf_fc_layout === 'text_only' ) ? str_replace("\n", "", $value->text) : '';

        })->toArray());
    }

    public function storeImage($data, $value, $imageOnly)
    {
        ( is_array( $value->image_size ) ) ? $imageSize = implode('|', $value->image_size) : $imageSize = $value->image_size;

        if ( $imageSize == 'url' ) {
            Storage::put($this->storagePath . $data->id . '/' .
                basename($value->image->{$imageSize}),
                file_get_contents($value->image->{$imageSize})
            );

            if ( $imageOnly ) {
                return "<img src='/storage/flexible_content/post_id_" . $data->id . "/" .
                    basename($value->image->{$imageSize}) . "'>";
            }

            return "<img src='/storage/flexible_content/post_id_" . $data->id . "/" .
                basename($value->image->{$imageSize}) . "'>" .
                str_replace("\n", "", $value->text);
        }
        else {
            Storage::put($this->storagePath . $data->id . '/' .
                basename($value->image->sizes->{$imageSize}),
                file_get_contents($value->image->sizes->{$imageSize})
            );

            if ( $imageOnly ) {
                return "<img src='/storage/flexible_content/post_id_" . $data->id . "/" .
                    basename($value->image->{$imageSize}) . "'>";
            }

            return "<img src='/storage/flexible_content/post_id_" . $data->id . "/" .
                basename($value->image->sizes->{$imageSize}) . "'>" .
                str_replace("\n", "", $value->text);
        }
    }

    public function getCategory($data)
    {
        $category = collect($data)->collapse()->first();
        $found    = Category::on($this->location)->where('slug', $category->slug)->first();

        if ($found) {
            return $found->id;
        }

        $cat        = new Category();
        $cat->setConnection($this->location);

        $cat->id    = $category->id;
        $cat->wp_id = $category->id;
        $cat->name  = $category->name;
        $cat->slug  = $category->slug;
        $cat->save();

        return $cat->id;
    }

    public function syncTags($post, $requestUrl)
    {
        $tags = collect($this->getJson($requestUrl));

        foreach ($tags as $data) {

            $found = Tag::on($this->location)->where('wp_id', $data->id)->first();

            if ( ! $found) {
                $this->createTag($post, $data);
            } else {
                $post->tags()->attach($data->id, ['taggables_type' => get_class($post)]);

                $found->clearMediaCollection();
                $found->clearMediaCollection('category_image');

                if (isset($data->acf->category_image)) {
                    if ($data->acf->category_image != false) {
                        $found->addMediaFromUrl($data->acf->category_image->url)
                            ->usingName('category_image')
                            ->toMediaCollection();
                    }
                }
            }
        }
    }

    public function createTag($post, $data)
    {
        $tag = new Tag;
        $tag->setConnection($this->location);

        $tag->id           = $data->id;
        $tag->wp_id        = $data->id;
        $tag->name         = $data->name;
        $tag->slug         = $data->slug;
        $tag->type         = (!empty($data->acf) ? $data->acf->group_name . 'Tag': '');
        $tag->order_column = 0;
        $tag->tag_type     = get_class($post);
        $tag->featured     = (isset($data->acf->featured) && $data->acf->featured) ? 1 : 0;

        $tag->save();

        $post->tags()->attach($tag->id, ['taggables_type' => get_class($post)]);

        if ($this->type != 'holiday-ideas' ||
            $this->type != 'askmum' ||
            $this->type != 'planner' ||
            $this->type != 'pages') {

            if (isset($data->acf->category_image)) {
                if ($data->acf->category_image != false) {
                    $tag->addMediaFromUrl($data->acf->category_image->url)
                        ->usingName('category_image')
                        ->toMediaCollection();
                }
            }
        }
    }

    protected function carbonDate($date)
    {
        return Carbon::parse($date);
    }

    protected function getJson($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER  , true);

        $data     = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpcode === 200) {
            $response = file_get_contents($url, false);
            return json_decode( $response );
        }

        return false;
    }
}
