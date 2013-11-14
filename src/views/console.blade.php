@include('laravel-console::partials.head')

<div id="console" class="console" data-action="{{ URL::route('console_execute') }}">
	<ul id="response" class="response">
	</ul>

	<nav id="controlbar" class="controlbar">
		<ul id="controls" class="controls">
		</ul>

		<div id="execute" class="execute">Execute</div>
	</nav>

	<section id="editor" class="editor">
	</section>
</div>

@include('laravel-console::partials.templates')
@include('laravel-console::partials.foot')