<?php

namespace App\Data\Models;

use App\Data\Models\Traits\BelongsToTeam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, BelongsToTeam;
    /**
     * The model's table
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * This are the mass assignable fields for the model
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];
    
}
