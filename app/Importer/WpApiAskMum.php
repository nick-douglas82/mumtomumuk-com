<?php

namespace App\Importer;

use App\Category;
use App\Importer\Importer;
use App\AskMum;
use App\Importer\Advertising\Advertising;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Importer\Seo\SEO;

Class WpApiAskMum
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
        $found = AskMum::where('wp_id', $data->id)->first();

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
            $post = AskMum::find($post);
            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = AskMum::pluck('wp_id');

        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Create ASK" . $data->id . " ";
        $post                    = new AskMum;

        $post->id         = $data->id;
        $post->wp_id      = $data->id;
        $post->user_id    = $data->author;
        $post->question   = $data->title->rendered;
        $post->slug       = $data->slug;
        $post->answer     = $data->content->rendered;
        $post->group      = (isset($data->_embedded->{"wp:term"})) ?  collect($data->_embedded->{"wp:term"})->collapse()->first()->name: '';
        $post->created_at = $this->carbonDate($data->date);
        $post->updated_at = $this->carbonDate($data->modified);

        $seo = new SEO($post, $data);
        $seo->create();

        $post->save();
    }

    protected function updatePost($foundPost, $data)
    {
        echo "Update ASK" . $data->id . " ";
        $post = AskMum::find($foundPost->id);
        $post->delete();
        $post->seo()->delete();

        $this->createPost($data);
    }
}
