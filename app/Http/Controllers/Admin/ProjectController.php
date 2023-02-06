<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
       
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    
    {
        
       
        //Validazione dove sfruttiamo la classe storeProjectRequest
        $data = $request->validated();
        
        
        //istanzio il posto come nuovo oggetto Project
        $new_project = new Project;

        // fill dei dati validati in precedenza
        $new_project->fill($data);

        //genero slug 
        $new_project->slug = Str::slug($new_project->title,'-');
        

          // Se esiste $data['cover_image'] faccio lo storage dell' immagine 
        if( isset($data['cover_image'] ) ) {

            $image_path = Storage::disk('public')->put('uploads', $data['cover_image']);

            //salvo immagine a db
            $new_project->cover_image = $image_path;
        }

        
        // salvo sul database
        $new_project->save();

        // redirect alla pagina index con messaggio nella variabile salvata in sessione
        return redirect()->route('admin.projects.index')->with('message', 'Progetto creato con successo');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data= $request->validated();
        
        $project->slug= Str::slug($data['title']);


        if( isset($data['cover_image'] ) ) {

            $data['cover_image'] =Storage::disk('public')->put('uploads', $data['cover_image']);

        }

        
        $project->update($data);
        
        return redirect()->route('admin.projects.index')->with('message', "il post $project->title è stato modificato" );


        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $old_title = $project->title;
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "Il progetto $old_title è stato eliminato");
    }
}
