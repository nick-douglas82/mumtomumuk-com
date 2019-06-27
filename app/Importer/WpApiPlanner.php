<?php

namespace App\Importer;

use App\Category;
use App\Importer\Frequency;
use App\Importer\Importer;
use App\Importer\PlannerEvent;
use App\Planner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

Class WpApiPlanner
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
        $found = Planner::where('wp_id', $data->id)->first();

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
            $post = Planner::where('wp_id', $post);
            $post->delete();
        }
    }

    protected function checkForUnsyncedPosts($apiPosts)
    {
        // IDs in API
        $posts    = Planner::pluck('wp_id');

        $diff     = $posts->diff($apiPosts)->unique();

        $this->deletePost($diff->all());
    }

    protected function createPost($data)
    {
        echo "Create Planner" . $data->id . " ";
        $event = new PlannerEvent($data);
        $event->create();
    }

    protected function updatePost($foundPost, $data)
    {
        echo "Update Planner" . $data->id . " " . $foundPost;
        $event = new PlannerEvent($data);
        $event->update();
    }
}
