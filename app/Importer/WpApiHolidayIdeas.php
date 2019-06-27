<?php

namespace App\Importer;

use App\Category;
use App\HolidayIdeas;
use App\Importer\Advertising\Advertising;
use App\Importer\Importer;
use Illuminate\Support\Facades\DB;
use App\Importer\Seo\SEO;

Class WpApiHolidayIdeas
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
        $found = HolidayIdeas::on($this->location)->where('wp_id', $data->id)->first();

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
            $post = HolidayIdeas::on($this->location)->find($post);

            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = HolidayIdeas::on($this->location)->pluck('wp_id');

        $diff     = $posts->diff($apiPosts);

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Create Holiday Ideas" . $data->id . " ";
        $post              = new HolidayIdeas;

        $post->id             = $data->id;
        $post->wp_id          = $data->id;
        $post->user_id        = $this->getAuthor($data->_embedded->author);
        $post->title          = $data->title->rendered;
        $post->slug           = $data->slug;
        $post->snippet        = $data->excerpt->rendered;
        $post->body           = $data->content->rendered;
        $post->content        = ( !empty($data->acf->content)) ? $this->buildContentArray($post, $data) : '';
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
        echo "Update Holiday Ideas" . $data->id . " ";
        $post = HolidayIdeas::find($foundPost->id);
        $post->delete();
        $post->seo()->delete();

        $this->createPost($data);
    }
}
