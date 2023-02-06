@extends('layouts.admin')

@section('content')
    
    <div class="container">
        <h1>{{ $project->title }}</h1>

        <div class="mt-4">

            <div class="w-25 mb-4" >
                @if ($project->cover_image )
                    <img src="{{ asset("storage/$project->cover_image ") }}" alt="{{ $project->title  }}">
                @endif
            </div>

            {{ $project->description }}

        </div>

    </div>
  

@endsection