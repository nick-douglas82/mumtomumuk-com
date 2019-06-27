<?php

namespace App\Importer;

use App\Category;
use App\BabyToddlerGroup;
use App\Importer\Advertising\Advertising;
use App\Importer\Importer;
use Illuminate\Support\Facades\DB;
use App\Importer\Seo\SEO;

Class WpApiBabyToddler
{
    use Importer;

    /* New instance of the model */
    protected $query;

    /* Wordpress API */
    protected $url = 'http://mumtomum.igloo-digital.co.uk/milton-keynes/wp-json/wp/v2/';

    /* String of targetted post type in Wordpress (eg posts) */
    protected $type;

    /* Set the location */
    protected $location;

    /* Set the Page */
    protected $page;

    /* Set the apiPosts */
    protected $apiPosts;

    public function __construct($type, $location)
    {
        $this->type     = $type;
        $this->location = $location;
        $this->page     = 1;
        $this->apiPosts = [];
    }

    protected function syncPost($data)
    {
        $found = BabyToddlerGroup::where('wp_id', $data->id)->first();

        if (! $found) {
            return $this->createPost($data);
        }

        if ($found and $found->updated_at->format("Y-m-d H:i:s") < $this->carbonDate($data->modified)->format("Y-m-d H:i:s")) {
            return $this->updatePost($found, $data);
        }
    }

    protected function deletePost($posts)
    {
        foreach ($posts as $post) {
            $post = BabyToddlerGroup::find($post);

            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = BabyToddlerGroup::pluck('wp_id');

        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Creating Baby Toddler" . $data->id . " ";

        $post              = new BabyToddlerGroup;

        $post->id          = $data->id;
        $post->wp_id       = $data->id;
        $post->user_id     = $this->getAuthor($data->_embedded->author);
        $post->slug        = $data->slug;
        $post->title       = $data->title->rendered;
        $post->body        = $data->content->rendered;
        $post->address     = $data->acf->google_map->address;
        $post->town        = $data->acf->town;
        $post->coordinates = DB::raw("GeomFromText('POINT(" . $data->acf->google_map->lat . " " . $data->acf->google_map->lng . " )')");
        $post->longitude   = $data->acf->google_map->lng;
        $post->latitude    = $data->acf->google_map->lat;
        $post->phone       = $data->acf->phone;
        $post->website     = $data->acf->web_address;
        $post->event_times = $data->acf->start_finish_text;
        $post->created_at  = $this->carbonDate($data->date);
        $post->updated_at  = $this->carbonDate($data->modified);

        if ($data->acf->main_image) {
            $post->addMediaFromUrl($data->acf->main_image)
                 ->usingName('main_image')
                 ->toMediaCollection();
        }

        $this->getGalleryImages($post, $data->acf->gallery_images);

        $this->syncTags($post, $data->_links->{"wp:term"}[0]->href);

        $seo = new SEO($post, $data);
        $seo->create();

        $advertising = new Advertising($post, $data, $this->url);
        $advertising->createLeaderboard()->createBillboard()->createMPU();

        $post->save();
    }

    protected function updatePost($foundPost, $data)
    {
        echo "Update Baby Toddler" . $data->id . " ";

        $post = BabyToddlerGroup::find($foundPost->id);
        $post->delete();
        $post->seo()->delete();

        $this->createPost($data);
    }
}
