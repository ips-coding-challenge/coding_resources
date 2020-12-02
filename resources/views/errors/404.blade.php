@extends('web.layouts.web')

@section('content')

<div class="mdl-layout">
	<!-- Navbar -->
	@include('web.partials.show_header', ['title' => "404" ])

	<main class="mdl-layout__content">
		<div class="page-content">
		<div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop mdl-cell--12-col-tablet">
			<img src="https://media.giphy.com/media/14uQ3cOFteDaU/source.gif" alt="planet turn around" style="width:100%">
		</div>
		</div>		
	</main>
</div>

@endsection

