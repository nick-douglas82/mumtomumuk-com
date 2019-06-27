<?php

namespace App\Importer\Seo;

use App\SEO;
use App\Importer\Seo\Helpers;


class Meta
{
    use Helpers;

    public function __construct($post, $data)
    {
        $this->post = $post;
        $this->data = $data;
    }

    public function handle()
    {
        return $this->post->seo()->updateOrCreate(
            [
                'meta_title'       => $this->title(),
                'meta_description' => $this->description(),
                'meta_keywords'    => $this->keywords(),
            ]
        );
    }

    private function title()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_title ) ?
                        $this->htmlEntities($this->data->yoast_meta->yoast_wpseo_title) : $this->renderTitle($this->data->title->rendered);
    }

    private function description()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_metadesc ) ?
                        $this->data->yoast_meta->yoast_wpseo_metadesc : $this->clean($this->data->content->rendered);
    }

    private function keywords()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_metakeywords ) ?
                        $this->data->yoast_meta->yoast_wpseo_metakeywords : '';
    }
}
