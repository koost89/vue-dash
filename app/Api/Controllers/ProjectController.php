<?php

namespace App\Api\Controllers;

use App\Api\Events\Project\ProjectAdded;
use App\Api\Events\Project\ProjectDeleted;
use App\Api\Events\Project\ProjectUpdated;
use App\Api\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('customer')->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'customer_id' => 'required|integer'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'customer_id' => $request->customer_id,
        ]);

        if(!$project){
            return new JsonResponse(['errors' => ['message' => 'Unable to save the project' ]], 500);
        }

        event(new ProjectAdded($project->load('customer')));

        return $project;

    }

    public function destroy(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
        ]);

        $project = Project::find($request->project_id);

        if(!$project) {
            return new JsonResponse(['errors' => ['message' => 'Project not found' ]], 404);
        }

        $project->delete();

        event(new ProjectDeleted($request->project_id));

        return new JsonResponse(['success' => ['message' => 'Project deleted' ]], 201);
    }

    public function update(Project $project, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_id' => 'required|integer',
        ]);

        $project->name = $request->name;
        $project->customer_id = $request->customer_id;
        $project->save();

        event(new ProjectUpdated($project->load('customer')));

        return $project;
    }
}
