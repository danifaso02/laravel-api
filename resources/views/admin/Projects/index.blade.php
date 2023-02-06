@extends('layouts.admin')

@section('content')
    <h1>Lista Projects</h1>

    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="my-4">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary" >Crea Project</a>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project)}}" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.projects.edit', $project)}}" class="btn btn-warning"><i class="fa-solid fa-pen"></i></a>

                            <form class="d-inline-block" action="{{route('admin.projects.destroy', $project)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" >Cancella</button>
                            </form>
                        </td>

                        
                    </tr>    
                @endforeach
            </tbody>
        </table>
    </div>
  

@endsection