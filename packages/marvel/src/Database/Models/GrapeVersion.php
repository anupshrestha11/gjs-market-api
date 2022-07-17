<?php

namespace Marvel\Database\Models;

use Illuminate\Database\Eloquent\Model;

class GrapeVersion extends Model
{

    protected $fillable = ['version', 'parent_id'];

    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($grapeVersion) {
            $grapeVersion->childs()->delete();
        });
    }


    /**
     * return grape version childs
     *
     * @return hasMany
     */
    public function childs()
    {
        return $this->hasMany(GrapeVersion::class, 'parent_id');
    }
}
