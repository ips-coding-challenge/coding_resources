@extends('web.layouts.web')

@section('content')

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" ref="mdl-layout">
	<!-- Navbar -->
	@include('web.partials.common_header', ['title' => "Search"])

	<main class="mdl-layout__content">
		<div class="page-content">
			<search-page namespace="search"></search-page>
		</div>		
	</main>
</div>

@endsection

