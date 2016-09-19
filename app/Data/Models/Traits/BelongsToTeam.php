<?php

namespace App\Data\Models\Traits;

use App\Data\Models\Team;

trait BelongsToTeam
{
    public static function bootBelongsToTeam()
    {
        static::creating(function ($model) {
            $model->team_id = \API::user()->activeTeam->id;
        });
    }

    public function newQuery()
    {
        $query = parent::newQuery();
        return $query->where(function ($q) {
            return $q->where('team_id', \API::user()->activeTeam->id);
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}