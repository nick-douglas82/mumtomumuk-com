<?php
namespace App;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    // public static function bootHasTags()
    // {
    //     static::created(function (Model $taggableModel) {
    //         $taggableModel->attachTags($taggableModel->queuedTags);
    //         $taggableModel->queuedTags = [];
    //     });

    //     static::deleted(function (Model $deletedModel) {
    //         $tags = $deletedModel->tags()->get();
    //         $deletedModel->detachTags($tags);
    //     });
    // }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggables');
    }

    /**
     *
     * @return $this
     */
    public function attachTags($tags, $type, $model)
    {
        $className = static::getTagClassName();
        $tags      = collect($className::findOrCreate($tags, $type, $model));

        $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }
}
