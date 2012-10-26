/*global jQuery: false, CodeMirror: false, tmpl: false, jwerty: false */
'use strict';

// Simple JavaScript Templating
// John Resig - http://ejohn.org/ - MIT Licensed
(function(){
	var cache = {};

	window.tmpl = function tmpl (str, data) {
		data = typeof data === 'string' ? { data: data } : data;

		// Figure out if we're getting a template, or if we need to
		// load the template - and be sure to cache the result.
		var fn = !/\W/.test(str) ? cache[str] = cache[str] || tmpl(document.getElementById('template_'+str).innerHTML) :

		// Generate a reusable function that will serve as a template
		// generator (and which will be cached).
		new Function("obj",
		"var p=[],print=function(){p.push.apply(p,arguments);};" +

		// Introduce the data as local variables using with(){}
		"with(obj){p.push('" +

		// Convert the template into pure JavaScript
		str
			.replace(/[\r\t\n]/g, " ")
			.split("{{").join("\t")
			.replace(/((^|\}\})[^\t]*)'/g, "$1\r")
			.replace(/\t=(.*?)\}\}/g, "',$1,'")
			.split("\t").join("');")
			.split("}}").join("p.push('")
			.split("\r").join("\\'") +
			"');}return p.join('');");

		// Provide some basic currying to the user
		return data ? fn( data ) : fn;
	};
})();

// Application
jQuery(function ($) {

	// Variables
	var $console = $('#console'),
		$output = $('#output'),
		$controllbar = $('#controllbar'),
		$editor = $('#editor'),
		$profiler = $('#anbu-open-tabs'),
		action = $console.data('action'),
		$execute = $('#execute'),
		$execution_diag = $('#execution_diag'),
		is_focused = 0,
		editor = new CodeMirror($editor[0], {
			mode: 'text/x-php',
			value: '',
			lineNumbers: true,
			indentWithTabs: true,
			matchBrackets: true,
			fixedGutter: true,
			autofocus: true,
			theme: $editor.data('theme'),
			onFocus: function () {
				is_focused = 1;
			},
			onBlur: function () {
				is_focused = 0;
			}
		}),
		execute = function() {
			var execution = $.ajax(action, {
				type: 'POST',
				cache: false,
				data: {
					code: editor.getValue()
				},
				timeout: 30000
			});

			$execution_diag.html(tmpl('execution_loading'));

			execution.done(function (res) {
				console.log('done response:', res);
				$output.show();

				if (res && res.output !== undefined) {
					$execution_diag.html(tmpl('execution_diag', res));
					$output.html(res.output ? tmpl('output', res.output) : tmpl('no_output'));
				} else {
					$execution_diag.html(tmpl('ended_unexpectedly'));
					$output.html(res);
				}

			}).fail(function (res) {
				console.log('fail response:', res);
				$execution_diag.html(tmpl('request_error', res));
				$output.show().html(res.responseText);

			}).always(function () {
				resize();
			});
		},
		reset = function (){
			$output.hide().html('');
			$execution_diag.html(tmpl('execution_intro'));
			resize();
		},
		resize = function () {
			var output_height = $output.is(':visible') ? $output.outerHeight() : 0,
				newHeight = Math.round($console.outerHeight() - output_height - $controllbar.outerHeight());

			editor.setSize(null, newHeight);
			$editor.height(newHeight);
		};

	// Legacy profiler support, before I realized it won't work that way :)
	// Offset console to account for profiler at the bottom
	if ($profiler.length) {
		$console.css({ bottom: $profiler.outerHeight() + 'px' });
	}

	// Execution initiators
	$output.on('click', function () {
		resize();
	});
	// Execution initiators
	$execute.on('click', function () {
		execute();
	});

	jwerty.key('ctrl+enter', function () {
		execute();
	});

	// Reset view
	jwerty.key('esc', function () {
		reset();
	});

	// Resize window
	$(window).on('resize', function () {
		resize();
	});

	// Refocus editor on typing
	$(document).on('keydown', function () {
		if (!is_focused) {
			editor.focus();
		}
	});

	// Initiate view reset
	reset();

});
