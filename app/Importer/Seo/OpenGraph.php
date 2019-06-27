<?php

namespace App\Importer\Seo;

use App\SEO;
use App\Importer\Seo\Helpers;

class OpenGraph
{
    use Helpers;

    public function __construct($post, $data, $item)
    {
        $this->post = $post;
        $this->data = $data;
        $this->item = $item;
    }

    public function handle()
    {
        SEO::find($this->item->id)->update([
            'opengraph_title'       => $this->title(),
            'opengraph_description' => $this->description(),
            'opengraph_image'       => $this->image('og')
        ]);

        return;
    }

    private function title()
    {
        return ($this->data->yoast_meta->yoast_wpseo_opengraph_title) ?
                            $this->htmlEntities($this->data->yoast_meta->yoast_wpseo_opengraph_title) : $this->renderTitle($this->data->title->rendered);
    }

    private function description()
    {
        return ($this->data->yoast_meta->yoast_wpseo_opengraph_description) ?
                            $this->data->yoast_meta->yoast_wpseo_opengraph_description : '';
    }
}