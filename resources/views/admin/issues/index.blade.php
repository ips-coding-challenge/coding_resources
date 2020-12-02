@extends('admin.layouts.app')

@section('content')

<div class="container">

    @if(count($conferencesIssue) > 0)
        <h2>Conferences issues</h2>
        @include('admin.issues._table', ['data' => $conferencesIssue])
    @endif

    @if(count($articlesIssue) > 0) 
        <h2>Articles issues</h2>
        @include('admin.issues._table', ['data' => $articlesIssue])
    @endif
    
    @if(count($tutosIssue) > 0) 
        <h2>Tutos issues</h2>
        @include('admin.issues._table', ['data' => $tutosIssue])
    @endif

    @if(count($booksIssue) > 0) 
        <h2>Books issues</h2>
        @include('admin.issues._table', ['data' => $booksIssue])
    @endif

    
</div>

@endsection