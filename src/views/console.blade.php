@include('console::partials.head')

<div id="console" class="console" data-action="{{ route('console_execute') }}">
	<ul id="response" class="response">
	</ul>

	<nav id="controlbar" class="controlbar">
		<ul id="controls" class="controls">
		</ul>
		<div id="execute" class="execute">Execute</div>
	</nav>

	<section id="editor" class="editor"></section>
</div>

@include('console::partials.templates')
@include('console::partials.foot')
