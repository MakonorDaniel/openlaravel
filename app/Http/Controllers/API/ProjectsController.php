<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;

class ProjectsController extends Controller
{
    /**
	 * @var app\Repositories\ProjectRepository;
	 */
	protected $project;

	public function __construct(ProjectRepository $project)
	{

		$this->project = $project;
	}

    /**
     * Display list of projects
     * 
     * @return Response
     */
    public function index()
    {
    	return  $this->project->get();
    }

     /**
     * Store project to the database
     * 
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'title' 		=> 'required|unique:projects,title',
    		'url'			=> 'url',
    		'repo_url'		=> 'required|url|unique:projects,repo_url',
            'short'         => 'required',
    		'description' 	=> 'required'
    	]);

    	$project = [
    		'title' 		=> $request->input('title'),
    		'slug' 			=> str_slug($request->input('title')),
    		'project_url' 	=> $request->input('url'),
    		'repo_url' 		=> $request->input('repo_url'),
            'short'         => $request->input('short'),
    		'description' 	=> $request->input('description')
    	];

    	$this->project->store($project);

    	return back()->with('status', 'Your submission has been made! Please give us some time to review your submission.');
    }

    /**
     * Show a specified project
     * 
     * @param  Project $slug
     * @return Response
     */
    // public function show($slug)
    // {
    //     $project = $this->project->show($slug);

    //     return view('projects.show', compact('project'));
    // }
}
