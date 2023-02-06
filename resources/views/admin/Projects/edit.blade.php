@extends('layouts.admin')

@section('content')
    
    <div class="container">
        <h1>Modifica: {{ 'title' }}</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mt-4">
           <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Inserisci il titolo" value="{{ old('title', $project->title) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Contenuto</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="Inserisci il contenuto">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="cover_image" class="form-label">Immagine</label>

                    <div class="mb-3">
                        <img id="output" width="100" @if ($project->cover_image) src="{{ asset("storage/$project->cover_image") }}"  @endif />
                        <script>
                            var loadFile = function(event) {
                                var reader = new FileReader();
                                reader.onload = function(){
                                var output = document.getElementById('output');
                                output.src = reader.result;
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            };
                        </script>
                    </div>
                    
                    <input type="file" class="form-control" id="cover_image" name="cover_image" value="{{ old('cover_image') }} " onchange="loadFile(event)">
                </div>
                
                <button type="submit" class="btn btn-primary">Modifica</button>
            </form>
        </div>
    </div>
  

@endsection