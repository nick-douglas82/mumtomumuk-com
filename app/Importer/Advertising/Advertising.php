<?php

namespace App\Importer\Advertising;

use Illuminate\Support\Facades\Storage;

class Advertising
{
    protected $post;

    protected $data;

    protected $url;

    public function __construct($post, $data, $url)
    {
        $this->post = $post;
        $this->url  = $url;
        $this->data = $data;
    }

    public function createLeaderboard()
    {
        if ( $this->data->acf->leaderboard->banner_id == '' ) {
            return $this;
        }

        $this->post->adverts()->create([
            'user_id'    => $this->data->author,
            'ad_type'    => 'leaderboard',
            'adsense_id' => $this->data->acf->leaderboard->banner_id,
        ]);

        return $this;
    }

    public function createBillboard()
    {
        if ( $this->data->acf->billboard->banner_id == '' ) {
            return $this;
        }

        $this->post->adverts()->create([
            'user_id'    => $this->data->author,
            'ad_type'    => 'billboard',
            'adsense_id' => $this->data->acf->billboard->banner_id,
        ]);

        return $this;
    }

    public function createMPU()
    {
        if ( ! $this->data->acf->mpu->mpu_banners ) {
            return $this;
        }

        $post = $this->post;
        $data = $this->data;

        collect($this->data->acf->mpu->mpu_banners)->each(function ($banner, $key) use ($post, $data) {

            $post->adverts()->create([
                'user_id'    => $data->author,
                'ad_type'    => 'mpu',
                'adsense_id' => $banner->banner_id,
            ]);
        });

        return $this;
    }

    public function update()
    {
        $this->post->adverts()->delete();

        $this->createLeaderboard();
        $this->createBillboard();
        $this->createMPU();
    }
}
