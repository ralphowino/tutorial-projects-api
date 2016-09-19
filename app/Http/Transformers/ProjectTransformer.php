<?php

namespace App\Http\Transformers;

use App\Data\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
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
     * @param Project $project
     * @return array
     */
    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'created_at' => (String)$project->created_at,
            'updated_at' => (String)$project->updated_at
        ];
    }
    
}
