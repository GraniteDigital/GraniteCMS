@extends('granitecms_dev.theme.views.layouts.default')

@section('content')
<div id="app">
	
	<form class="form-wrapper cf">
		<button type="submit" v-on:click="search">Search</button>
	  	<input type="text" placeholder="Search here..." required v-model="searchInput">
	</form>

	<div v-for="item in sites">

		<div class="left-image">

		</div>
		<div class="right-info">
			<a v-bind:href="[ item.url ]" target="_BLANK"><h2>@{{ item.name }}</h2></a>
			<a v-bind:href="[ item.url ]" target="_BLANK">Link</a>
			<p>
				<strong>Developers: </strong> @{{ item.developers }}
			</p>

			<p>
				<strong>Project Managers: </strong> @{{ item.project_managers }}
			</p>
		</div>
	</div>
</div>
@stop

