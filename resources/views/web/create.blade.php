@extends('web.layouts.web')

@section('seo')
    {!! SEOMeta::generate() !!}
	{!! OpenGraph::generate() !!}
@endsection

@section('content')

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" ref="mdl-layout">
	<!-- Navbar -->
	@include('web.partials.show_header', ['title' => "Add a link" ])

	<main class="mdl-layout__content">
		<div class="page-content">                
            <add-form></add-form>			
		</div>		
	</main>
</div>

@endsection
