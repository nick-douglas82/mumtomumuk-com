<?php

namespace App\Importer;

use App\Category;
use App\Importer\Importer;
use App\Post;
use App\Tag;
use App\Importer\Advertising\Advertising;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Importer\Seo\SEO;

Class WpApiPost
{
    use Importer;

    /* New instance of the model */
    protected $query;

    /* Wordpress API */
    protected $url = 'http://mumtomum.igloo-digital.co.uk/milton-keynes/wp-json/wp/v2/';
    // protected $url = 'http://mumswp.igloo-digital.co.uk/milton-keynes/wp-json/wp/v2/';

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
        $found = Post::where('wp_id', $data->id)->first();

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
            $post = Post::find($post);
            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = Post::pluck('wp_id');

        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Create Post" . $data->id . " ";
        $post                 = new Post;

        $post->id             = $data->id;
        $post->wp_id          = $data->id;
        $post->user_id        = $data->author;
        $post->title          = $data->title->rendered;
        $post->slug           = $data->slug;
        $post->snippet        = $data->excerpt->rendered;
        $post->body           = $data->content->rendered;
        $post->content        = (!empty($data->acf->content)) ? $this->buildContentArray($post, $data) : '';
        $post->category_id    = (isset($data->_embedded->{"wp:term"})) ? $this->getCategory($data->_embedded->{"wp:term"}) : '';
        $post->allow_comments = ($data->comment_status === "closed") ? false : true;
        $post->created_at     = $this->carbonDate($data->date);
        $post->updated_at     = $this->carbonDate($data->modified);

        if ($data->acf->main_image) {
            $post->addMediaFromUrl($data->acf->main_image)
                ->usingName('main_image')
                ->toMediaCollection();
        }

        $seo = new SEO($post, $data);
        $seo->create();

        $advertising = new Advertising($post, $data, $this->url);
        $advertising->createLeaderboard()->createBillboard()->createMPU();

        $post->save();
    }

    protected function updatePost($foundPost, $data)
    {
        echo "Update Post" . $data->id . " ";
        $post = Post::find($foundPost->id);
        $post->delete();
        $post->seo()->delete();

        $this->createPost($data);
    }
}
