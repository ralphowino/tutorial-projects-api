<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    /**
     * The model's table
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * This are the mass assignable fields for the model
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'purpose'];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->team_owner = \API::user()->id;
        });
    }

    /**
     * Links to it's members
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')->withTimestamps();
    }

    public function getActiveAttribute()
    {
        return is_null($this->delete_at);
    }

    public function getOwnerAttribute()
    {
        return $this->members->wherePivot('owner',1)->first();
    }
}
