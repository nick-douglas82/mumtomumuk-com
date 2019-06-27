<?php

namespace App\Importer\Seo;

use App\SEO;

class Other
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
            'focus_keyword' => $this->focusKeyword(),
            'canonical'     => $this->canonicalURL()
        ]);

        return;
    }

    private function focusKeyword()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_focuskw ) ?
                                            $this->data->yoast_meta->yoast_wpseo_focuskw : "";
    }

    private function canonicalURL()
    {
        return ( $this->data->yoast_meta->yoast_wpseo_canonical ) ?
                                            $this->data->yoast_meta->yoast_wpseo_canonical : "";
    }
}