<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

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
}
