<?php

namespace App\Http\Controllers\Api;

use App\Data\Models\User;
use App\Http\Requests;
use App\Http\Transformers\TeamTransformer;
use App\Http\Transformers\UserTransformer;
use Illuminate\Http\Request;

class TeamsController extends Controller
{

    protected $transformer;

    public function __construct(TeamTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function index()
    {
        $teams = \API::user()->teams()->get();
        return $this->response()->collection($teams, $this->transformer);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | max:255',
            'slug' => 'required | max:255 | unique:teams,slug'
        ]);
        $team = \API::user()->teams()->create($request->only(['name', 'slug', 'purpose']));
        return $this->response()->item($team, $this->transformer)->statusCode(201);
    }

    public function show($slug)
    {
        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        return $this->response()->item($team, $this->transformer);
    }

    public function update($slug, Request $request)
    {
        $this->validate($request, [
            'name' => 'required | max:255',
            'slug' => 'required | max:255 | unique:teams,slug,' . $slug . ',slug'
        ]);

        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        $team->update($request->only(['name', 'slug', 'purpose']));
        return $this->response()->item($team, $this->transformer);
    }


    public function destroy($slug, Request $request)
    {
        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        $team->delete();
        return $this->response()->noContent();
    }

    public function getMembers($slug)
    {
        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        return $this->response()->collection($team->members, new UserTransformer());
    }

    public function addMember($slug, Request $request)
    {
        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        $user = User::firstOrCreate(
            $request->only('email'),
            [
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]
        );
        if (!$team->members()->where('user_id', $user->id)->count()) {
            $team->members()->attach($user->id);
        }
        return $this->response()->item($user, new UserTransformer());
    }

    public function removeMember($slug, $id)
    {
        $team = \API::user()->teams()->whereSlug($slug)->firstOrFail();
        $team->members()->detach($id);
        return $this->response()->noContent();
    }

}
