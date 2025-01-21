<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json($project);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'created_by' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }


    $data = $request->all();
    if (!isset($data['created_by'])) {
        return response()->json(['error' => 'created_by is required'], 400);
    }

    $project = Project::create($data);
    return response()->json($project, 201);
}

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $project->update($request->all());
        return response()->json($project, 200);
    }

    public function destroy($id)
{
    $project = Project::find($id);
    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    $project->tasks()->delete();

    $project->delete();
    return response()->json(null, 204);
}
}
