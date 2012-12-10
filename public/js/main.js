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
			lineNumbers: true,
			indentUnit: 4,
			tabSize: 4,
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
			},
			onChange: function () {
				if (Modernizr.localstorage && localStorage.remember == 1) {
					localStorage.code = editor.getValue();
				}
			},
			onCursorActivity: function () {
				if (Modernizr.localstorage && localStorage.remember == 1) {
					var cursor = editor.getCursor();
					localStorage.line = cursor.line;
					localStorage.char = cursor.ch;
				}
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

				if (res && res.output !== undefined && res.query_output !== undefined) {
					$execution_diag.html(tmpl('execution_diag', res));
					var output_html = (res.output) ? tmpl('output', res.output) : '';
					var query_html = (res.query_output) ? tmpl('query', res.query_output) : '';
					$output.html((output_html || query_html) ? (output_html + query_html) : tmpl('no_output'));
				} else {
					$execution_diag.html(tmpl('ended_unexpectedly'));
					$output.html(res);
				}

			}).fail(function (res) {
				console.log('fail response:', res);
				$execution_diag.html(tmpl('request_error', res));
				$output.show().html(res.responseText);
			}).always(function () {
				$output.imagesLoaded(resize);
			});
		},
		reset = function (){
			$output.hide().html('');
			$execution_diag.html(tmpl('execution_intro', { checked: Modernizr.localstorage && localStorage.remember == 1 }));
			resize();
		},
		resize = function () {
			var output_height = $output.is(':visible') ? $output.outerHeight() : 0,
				newHeight = Math.round($console.outerHeight() - output_height - $controllbar.outerHeight());

			editor.setSize(null, newHeight);
			$editor.height(newHeight);
		};

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
		editor.focus();
	});

	// Refocus editor on pressing TAB
	jwerty.key('tab', function () {
		if (!is_focused) {
			editor.focus();
			return false;
		}
	});

	// Resize window
	$(window).on('resize', function () {
		resize();
	});

	// Remember code
	if (Modernizr.localstorage) {
		var checked_class = 'checked';

		// Restore the last editor state
		if (Modernizr.localstorage && localStorage.remember == 1) {
			editor.setValue(localStorage.code);
			editor.setCursor(localStorage.line ? localStorage.line / 1 : 0, localStorage.char ? localStorage.char / 1 : 0);
		}

		$execution_diag.on('click', '.remember .button', function (event) {

			var do_remember = localStorage.remember != 1,
				cursor = editor.getCursor();

			$(this)[do_remember ? 'addClass' : 'removeClass'](checked_class);

			if (do_remember) {
				localStorage.remember = 1;
				localStorage.code = editor.getValue();
				localStorage.line = cursor.line;
				localStorage.char = cursor.ch;
			} else {
				localStorage.clear();
			}

		})[localStorage.remember == 1 ? 'addClass' : 'removeClass'](checked_class);
	}

	// Initiate view reset
	reset();

});
