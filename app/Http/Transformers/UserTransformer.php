<?php

namespace App\Http\Transformers;

use App\Data\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['teams'];

    /**
     * Turn this item object into a generic array
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => (String)$user->created_at,
            'updated_at' => (String)$user->updated_at
        ];
    }
    
    /**
     * Include Teams
     *
     * @param User $user
     * @return \League\Fractal\Resource\collection
     */
    public function includeTeams(User $user)
    {
        $teams = $user->teams;
        return $this->collection($teams, new TeamTransformer());
    }
}
