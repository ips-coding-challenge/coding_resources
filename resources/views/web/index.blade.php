@extends('web.layouts.web')

@section('seo')
{!! SEOMeta::generate() !!}
@endsection

@section('content')

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs index__container" ref="mdl-layout">
	<!-- Navbar -->
	@include('web.partials.index_header')
</div>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored fab-filters" @click.prevent="openFilters" v-show="!isOpen">
      <i class="material-icons">add</i>
</button>

<filters></filters>


@endsection


