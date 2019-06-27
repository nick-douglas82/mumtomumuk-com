<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Tag extends Model implements HasMediaConversions
{
    use HasMediaTrait, TagImageConversion;

    public $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function url($site, $url)
    {
        return url($site . '/' . $url . '/?tag=' . $this->id);
    }

    function scopeTagGroup($query, $group)
    {
        return $query->where('tag_type', $group);
    }

    function scopeRandomOrder($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }


    public static function findOrCreate($values, string $type = null, $model)
    {
        $tags = collect($values)->map(function ($value) use ($type, $model) {
            if ($value instanceof Tag) {
                return $value;
            }
            return static::findOrCreateFromString($value, $type, $model);
        });
        return is_string($values) ? $tags->first() : $tags;
    }


    public static function findFromString(string $name, string $type = null, $model)
    {
        return static::query()
            ->where('name', $name)
            ->where('type', $type)
            ->where('tag_type', $model)
            ->first();
    }

    protected static function findOrCreateFromString(string $name, string $type = null, $model): Tag
    {
        $tag = static::findFromString($name, $type, $model);
        if (! $tag) {
            $tag = static::create([
                'name'     => $name,
                'type'     => $type,
                'slug'     => str_slug($name, '-'),
                'tag_type' => get_class($model)
            ]);
        }
        return $tag;
    }

    /**
     * Tag belongs to Places.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function places()
    {
        return $this->belongsToMany(Place::class);
    }
}
