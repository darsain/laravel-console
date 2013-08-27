@include('console::partials.head')

<div id="console" class="console" data-action="{{ URL::route('execute') }}">
	<ul id="tabs" class="tabs">
	</ul>

	<nav id="controllbar" class="controllbar">
		<ul id="execution_diag" class="execution_diag">
		</ul>

		<div id="execute" class="execute">Execute</div>
	</nav>

	<section id="editor" class="editor" data-theme="{{ Config::get('console.theme', Config::get('console::theme')) }}">
	</section>
</div>

@include('console::partials.templates')
@include('console::partials.foot')