<?php

namespace App\Importer;

use App\Category;
use App\Importer\Importer;
use App\Importer\Advertising\Advertising;
use App\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Importer\Seo\SEO;

Class WpApiPage
{
    use Importer;

    /* New instance of the model */
    protected $query;

    /* Wordpress API */
    protected $url = 'http://mumtomum.igloo-digital.co.uk/milton-keynes/wp-json/wp/v2/';

    /* String of targetted post type in Wordpress (eg posts) */
    protected $type;

    /* String of the end of the api */
    protected $apiEnd;

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
        $found = Page::on($this->location)->where('wp_id', $data->id)->first();

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
            $post = Page::on($this->location)->find($post);

            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = Page::on($this->location)->pluck('wp_id');

        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Create Page" . $data->id . " " . $this->url($data->slug) . " ";
        $post             = new Page;

        $post->id         = $data->id;
        $post->wp_id      = $data->id;
        $post->user_id    = $data->author;
        $post->slug       = $this->url($data->slug);
        $post->title      = $data->title->rendered;
        $post->body       = $data->content->rendered;
        $post->created_at = $this->carbonDate($data->date);
        $post->updated_at = $this->carbonDate($data->modified);

        $pages = [
            "homepage",
            "holiday-ideas",
            "blog",
            "posts",
            "rebecca-reviews",
            "directory",
            "places-to-go",
            "4-plus-activities",
            "baby-toddler-groups",
            "events-2"
        ];

        if ( ! in_array($data->slug, $pages) ) {
            if ($data->acf->main_image != false) {

                $post->addMediaFromUrl($data->acf->main_image)
                    ->usingName('main_image')
                    ->toMediaCollection();

            }
        }

        $seo = new SEO($post, $data);
        $seo->create();

        $advertising = new Advertising($post, $data, $this->url);
        $advertising->createLeaderboard()->createBillboard()->createMPU();

        $post->save();
    }

    protected function updatePost($foundPost, $data)
    {
        echo "Update Page" . $data->id . " ";
        $post = Page::find($foundPost->id);
        $post->delete();
        $post->seo()->delete();

        $this->createPost($data);
    }

    public function url($slug)
    {
        switch ($slug) {
            case 'homepage':
                return '/';
                break;

            case 'posts':
                return 'blog/posts';
                break;

            case 'rebecca-reviews':
                return 'blog/rebecca-reviews';
                break;

            case 'events-2':
                return 'events';
                break;

            default:
                return $slug;
                break;
        }
    }
}
