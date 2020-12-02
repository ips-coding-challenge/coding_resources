@extends('web.layouts.web')

@section('seo')
    {!! SEOMeta::generate() !!}
	{!! OpenGraph::generate() !!}
@endsection

@section('content')

<div class="mdl-layout">
	<!-- Navbar -->
	@include('web.partials.show_header', ['title' => "About" ])

	<main class="mdl-layout__content">
		<div class="page-content">
            I made this
		</div>		
	</main>
</div>

@endsection

