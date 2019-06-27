<?php

namespace App\Importer\Seo;

use App\SEO;

class Robots
{
    public function __construct($post, $data, $item)
    {
        $this->post = $post;
        $this->data = $data;
        $this->item = $item;
    }

    public function handle()
    {
        SEO::find($this->item->id)->update([
            'meta_robots_noindex'  => $this->noindex(),
            'meta_robots_nofollow' => $this->nofollow()
        ]);

        return;
    }

    private function noindex()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_meta_robots_noindex === "1" ) ? false : true;
    }

    private function nofollow()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_meta_robots_nofollow === "1" ) ? false : true;
    }
}