<?php
namespace App\Importer\Seo;

use Spatie\MediaLibrary\Media;

trait Helpers
{
    private function renderTitle($title)
    {
        return ( $title === "Homepage" ) ? "Mum to Mum UK | Milton Keynes" : $this->htmlEntities($title);
    }

    private function image($type)
    {
        if ( $type === 'og' ) {

            if ( ! $this->data->yoast_meta->yoast_wpseo_opengraph_image ) {
                Media::where('model_id', $this->post->id)->delete();

                return;
            }

            $this->post->addMediaFromUrl($this->data->yoast_meta->yoast_wpseo_opengraph_image)
                ->usingName('og_meta')
                ->toMediaCollection('og_meta');

            return $this->data->yoast_meta->yoast_wpseo_opengraph_image;
        }
        else {

            if ( ! $this->data->yoast_meta->yoast_wpseo_twitter_image ) {
                Media::where('model_id', $this->post->id)->delete();

                return;
            }

            $this->post->addMediaFromUrl($this->data->yoast_meta->yoast_wpseo_twitter_image)
                ->usingName('twitter_meta')
                ->toMediaCollection('twitter_meta');

            return $this->data->yoast_meta->yoast_wpseo_twitter_image;
        }
    }

    private function clean($description)
    {
        $description = strip_tags($description);
        $description = trim(preg_replace('/\s+/', ' ', $description));
        $description = $this->htmlEntities($description);

        return str_limit($description, 230);
    }

    private function htmlEntities($string)
    {
        return html_entity_decode($string);
    }
}