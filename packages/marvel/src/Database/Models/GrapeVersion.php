<?php

namespace Marvel\Database\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class GrapeVersion extends Model
{

    use Sluggable;

    protected $fillable = ['version', 'parent_id'];

    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($grapeVersion) {
            $grapeVersion->children()->delete();
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'version'
            ]
        ];
    }


    /**
     * return grape version childs
     *
     * @return hasMany
     */
    public function children()
    {
        return $this->hasMany(GrapeVersion::class, 'parent_id');
    }


    /**
     * parent
     *
     * @return hasOne
     */
    public function parent()
    {
        return $this->hasOne(GrapeVersion::class, 'id', 'parent_id');
    }
}
