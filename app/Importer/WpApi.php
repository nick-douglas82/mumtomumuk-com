<?php

namespace App\Importer;

use App\Post;
use Carbon\Carbon;

Class WpApi
{
    /*
     * Define the API route
     */
    protected $url;

    /*
     * Define the site id
     */
    protected $site_id;

    public function __construct($url, $site_id)
    {
        $this->url     = $url;
        $this->site_id = $site_id;
    }

    public function import($page = 1)
    {
        $types = [
            ['name' => 'Posts', 'route' =>'posts'],
            // ['name' => 'RebeccaReviews', 'route' =>'rebecca-reviews'],
        ];

        foreach ($types as $type) {
            call_user_func(__NAMESPACE__ .'\WpApi::import' . $type['name'], $page, $type['route']);
        }
    }

    protected function importPosts($page, $apiRoute)
    {
        $posts = collect($this->getJson($this->url . $apiRoute . '/?_embed&filter[orderby]=modified&page=' . $page));
        $query = (new Post)->newQuery();

        $this->sync($posts, $query);
        $this->clean($posts);
    }

    /* Reuse */
    protected function sync($posts, $query)
    {
        foreach ($posts as $post) {
            $this->syncPost($post, $query);
        }
    }

    protected function syncPost($data, $query)
    {
        $found = $query->where('site_id', $this->site_id)->where('wp_id', $data->id)->first();

        if (! $found) {
            return $this->createPost($data);
        }

        if ($found and $found->updated_at->format("Y-m-d H:i:s") < $this->carbonDate($data->modified)->format("Y-m-d H:i:s")) {
            return $this->updatePost($found, $data);
        }
    }

    /* Reuse */
    protected function clean($posts)
    {
        $this->checkForUnsyncedPosts($posts);
    }

    protected function createPost($data)
    {
        $post                    = new Post();
        $post->id                = $data->id;
        $post->wp_id             = $data->id;
        $post->user_id           = $data->author; // TODO: check on multiple authors.
        $post->site_id           = $this->site_id;
        $post->title             = $data->title->rendered;
        $post->slug              = $data->slug;
        // $post->featured_image = $this->featuredImage($data->_embedded);
        // $post->featured       = ($data->sticky) ? 1 : null;
        $post->snippet           = $data->excerpt->rendered;
        $post->body              = $data->content->rendered;
        // $post->format         = $data->format;
        // $post->status         = 'publish';
        // $post->publishes_at   = $this->carbonDate($data->date);
        $post->created_at        = $this->carbonDate($data->date);
        $post->updated_at        = $this->carbonDate($data->modified);
        // $post->category_id    = $this->getCategory($data->_embedded->{"wp:term"});
        $post->save();
        // $this->syncTags($post, $data->_embedded->{"wp:term"});
        return $post;
    }

    protected function updatePost($foundPost, $data)
    {
        $post             = Post::find($foundPost->id);
        $post->user_id    = $data->_embedded->author[0]->id; // TODO: check on multiple authors.
        $post->title      = $data->title->rendered;
        $post->slug       = $data->slug;
        $post->snippet    = $data->excerpt->rendered;
        $post->body       = $data->content->rendered;
        $post->created_at = $this->carbonDate($data->date);
        $post->updated_at = $this->carbonDate($data->modified);
        $post->save();

        return $post;
    }

    protected function deletePost($posts)
    {
        foreach ($posts as $post) {
            $post = Post::find($post)->where('site_id', $this->site_id);
            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($posts)
    {
        // IDs in API
        $apiPosts = $posts->pluck('id')->toArray();
        $posts    = Post::all()->pluck('wp_id');
        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function carbonDate($date)
    {
        return Carbon::parse($date);
    }

    protected function getJson($url)
    {
        $response = file_get_contents($url, false);
        return json_decode( $response );
    }

}
