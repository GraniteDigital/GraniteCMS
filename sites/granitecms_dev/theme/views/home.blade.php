@extends('granitecms_dev.theme.views.layouts.default')

@section('content')
<div id="app">
	
	<form class="form-wrapper cf">
	  	<input type="text" placeholder="Search here..." required v-model="searchInput">
		<button type="submit" v-on:click="search">Search</button>
	</form>
	@{{searchInput}}
</div>
@stop

