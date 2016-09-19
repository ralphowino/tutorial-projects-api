<?php

namespace App\Http\Transformers;

use App\Data\Models\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * Turn this item object into a generic array
     *
     * @param Team $team
     * @return array
     */
    public function transform(Team $team)
    {
        return [
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'purpose' => $team->purpose,
            'active' => $team->active,
            'created_at' => (String)$team->created_at,
            'updated_at' => (String)$team->updated_at
        ];
    }
    
}
