@include('console::partials.head')

<div id="console" class="console" data-action="{{ URL::route('console_execute') }}">
	<ul id="response" class="response">
	</ul>

	<nav id="controlbar" class="controlbar">
		<ul id="controls" class="controls">
		</ul>
		<div id="execute" class="execute">Execute</div>
	</nav>

	<section id="editor" class="editor"></section>
  <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
</div>

@include('console::partials.templates')
@include('console::partials.foot')
