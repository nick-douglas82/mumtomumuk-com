<?php

namespace App\Importer\Seo;

use App\SEO;
use App\Importer\Seo\Helpers;

class Twitter
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
            'twitter_title'       => $this->title(),
            'twitter_description' => $this->description(),
            'twitter_image'       => $this->image('twitter')
        ]);

        return;
    }

    private function title()
    {
        return ($this->data->yoast_meta->yoast_wpseo_twitter_title) ?
                            $this->htmlEntities($this->data->yoast_meta->yoast_wpseo_twitter_title) : $this->renderTitle($this->data->title->rendered);
    }

    private function description()
    {
        return ($this->data->yoast_meta->yoast_wpseo_twitter_description) ?
                            $this->data->yoast_meta->yoast_wpseo_twitter_description : '';
    }
}