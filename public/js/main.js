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
		new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};" +

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
		$tabs = $('#tabs'),
		$controllbar = $('#controllbar'),
		$editor = $('#editor'),
		action = $console.data('action'),
		$execute = $('#execute'),
		$execution_diag = $('#execution_diag'),
		is_focused = 0,
		tabs = {
			active: 'output',
			initial: 'output',
			activeClass: 'active'
		},
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
				$tabs.show();

				if (res && res.output !== undefined) {
					$execution_diag.html(tmpl('execution_diag', res));
					$tabs.html(tmpl('output', res));
					toggle(tabs.active, 1);
				} else {
					$execution_diag.html(tmpl('ended_unexpectedly'));
					$tabs.html(tmpl('output', res));
					toggle(tabs.initial, 1);
				}
			}).fail(function (res) {
				console.log('fail response:', res);
				$execution_diag.html(tmpl('request_error', res));
				$tabs.show().html(tmpl('output', res.responseText));
			}).always(function () {
				$tabs.imagesLoaded(resize);
			});
		},
		toggle = function (tab, force) {
			var $holders = $tabs.children(),
				$buttons = $execution_diag.find('[data-toggle]'),
				newTab = force ? tab : tabs.active === tab ? tabs.initial : tab;

			$buttons.removeClass(tabs.activeClass).filter('[data-toggle=' + newTab + ']').addClass(tabs.activeClass);

			$holders.hide().filter('[data-tab=' + newTab + ']').show();
			tabs.active = newTab;

			resize();
		},
		reset = function () {
			$tabs.hide().html('');
			$execution_diag.html(tmpl('execution_intro', { checked: Modernizr.localstorage && localStorage.remember == 1 }));
			resize();
		},
		resize = function () {
			var output_height = $tabs.is(':visible') ? $tabs.outerHeight() : 0,
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

	// Toggle profiler tabs
	$execution_diag.on('click', '[data-toggle]', function () {
		toggle($(this).data('toggle'));
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

		$execution_diag.on('click', '.remember .button', function () {

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
