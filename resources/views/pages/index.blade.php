@extends('layouts.app')

@section('content')
    <section>
        @foreach ($jobs as $job);
            <div class="card mx-auto" style="width:50rem">
                <div class="card-body">
                <h2><a href="{{ route('job', ['id' => $job->id]) }}">{{ $job->title }}</a></h2>
                <h6 class="card-subtitle text-muted">Subtitle</h6>
                <p class="card-text">A card is a flexible and extensible content container. It includes ...</p>
                <a href="#" class="card-link">Card link</a>
                <example-component></example-component>
                </div>
            </div>
        @endforeach
    </section>
@endsection