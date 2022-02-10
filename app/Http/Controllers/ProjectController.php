<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Utils\StaticTools;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $projects = Project::paginate(10)->toJson();
        return view('admin.projects.index')->with('projects', $projects);
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(ProjectStoreRequest $request)
    {
        $validated = $request->validated();

        $plants_ids = explode(',', $request->all()['plants']);
        $coordinates = $validated['long'] . ';' . $validated['lat'];

        $project = new Project([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'place' => $request->place || $request->name,
            'area' => $validated['area'],
            'client' => isset($request->client) ? $request->client : '-',
            'doneby' => isset($request->doneby) ? $request->doneby : '-',
            'coordinates' => $coordinates
        ]);

        if($project->save())
        {
            foreach ($plants_ids as $plants_id) {
                DB::table('project_plants')
                    ->insert([
                       'project_id' => $project->id,
                       'plant_id' => $plants_id
                    ]);
            }
        }

        StaticTools::saveImages($request->images, $project, 'projects/'.$project->id);

        return redirect()->intended(route('projects.index'));
    }
}
