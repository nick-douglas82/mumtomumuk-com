<?php

namespace App\Importer\Seo;

use App\Importer\Seo\Meta;
use App\Importer\Seo\OpenGraph;
use App\Importer\Seo\Twitter;
use App\Importer\Seo\Robots;


class SEO {

    public function __construct($post, $data)
    {
        $this->post = $post;
        $this->data = $data;
    }

    public function create()
    {
        $meta = new Meta($this->post, $this->data);
        $seo = $meta->handle();

        $opengraph = new OpenGraph($this->post, $this->data, $seo);
        $opengraph->handle();

        $twitter = new Twitter($this->post, $this->data, $seo);
        $twitter->handle();

        $robots = new Robots($this->post, $this->data, $seo);
        $robots->handle();

        $other = new Other($this->post, $this->data, $seo);
        $other->handle();
    }

    public function update()
    {
        $this->post->seo()->delete();
        $this->create();
    }
}
