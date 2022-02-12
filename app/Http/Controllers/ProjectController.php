<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Image;
use App\Utils\StaticTools;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $projects = Project::paginate(10);
        foreach ($projects as $project) {
            $project['plants'] = $project->plants();
        }

        return view('admin.projects.index')->with('projects', $projects->toJson());
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
        $coordinates = $validated['lat'] . ';' . $validated['long'];

        $project = new Project([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'place' => $request->place || $request->name,
            'area' => $validated['area'],
            'client' => isset($request->client) ? $request->client : '',
            'doneby' => isset($request->doneby) ? $request->doneby : '',
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

    public function edit($id)
    {
        $project = Project::with(['images'])->findOrFail($id);
        $coordinates = explode(';',$project->coordinates);
        $project['plants'] = $project->plants();
        $project['long'] = $coordinates[0];
        $project['lat'] = $coordinates[1];

        return view('admin.projects.edit')->with('project', $project);
    }

    public function update(ProjectStoreRequest $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validated();

        $plants_ids = explode(',', $request->all()['plants']);
        $coordinates = $validated['lat'] . ';' . $validated['long'];

        DB::table('project_plants')
            ->where('project_id', $id)
            ->delete();

        $project->fill([
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

        if(isset($request->images_to_delete))
        {
            foreach ($request->images_to_delete as $image_id) {
                $images = array_values(Image::select('icon','small','medium','large')
                    ->where('id', $image_id)->get()->toArray()[0]);

                Storage::disk('images')->delete($images);
            }
            Image::whereIn('id', $request->images_to_delete)
                ->delete();
        }

        return redirect()->intended(route('projects.index'));
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        foreach ($project->images()->pluck('id') as $image_id) {
            $images = array_values(Image::select('icon','small','medium','large')
                ->where('id', $image_id)->get()->toArray()[0]);

            Storage::disk('images')->delete($images);
        }

        $project->images()->delete();
        $project->delete();

        return redirect()->intended(route('projects.index'));
    }
}
