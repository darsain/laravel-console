/*global jQuery: false, CodeMirror: false, tmpl: false, jwerty: false */
'use strict';

/**
 * Format byte size into human readable form.
 *
 * @param {Integer} size
 *
 * @return {String}
 */
function niceBytesize(size) {
	var i = Math.max(Math.floor(Math.log(0|size) / Math.log(1024)), 0);
	return Math.round(size / Math.pow(1024, i), 2).toFixed(0) + ' ' + niceBytesize.units[i];
}
niceBytesize.units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];

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
		/*jshint evil:true */
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
	var $console = $('#console');
	var $response = $('#response');
	var $controlbar = $('#controlbar');
	var $editor = $('#editor');


	var action = $console.data('action');
	var $execute = $('#execute');
	var $controls = $('#controls');
	var is_focused = 0;
	var tabs = {
		active: 'output',
		initial: 'output',
		activeClass: 'active'
	};
	var editor = new CodeMirror($editor[0], {
		mode: 'text/x-php',
		theme: 'laravel',
		lineNumbers: true,
		indentUnit: 4,
		tabSize: 4,
		indentWithTabs: true,
		autofocus: true
	});

	editor.on('focus', function () {
		is_focused = 1;
	});

	editor.on('blur', function () {
		is_focused = 0;
	});

	editor.on('change', function () {
		if (Modernizr.localstorage && localStorage.remember / 1 === 1) {
			localStorage.code = editor.getValue();
		}
	});

	editor.on('cursorActivity', function () {
		if (Modernizr.localstorage && localStorage.remember / 1 === 1 && is_focused) {
			var cursor = editor.getCursor();
			localStorage.line = cursor.line;
			localStorage.char = cursor.ch;
		}
	});

	/**
	 * Send a code to be executed, and handle the response.
	 *
	 * @return {Void}
	 */
	function execute() {
		var execution = $.ajax(action, {
			type: 'POST',
			cache: false,
      headers: { 'X-CSRF-TOKEN': Laravel.csrfToken },
			data: {
				code: editor.getValue()
			},
			dataType: 'text',
			timeout: 30000
		});

		$controls.html(tmpl('controls_loading'));
		execution.then(responseDone, responseFail);
	}

	/**
	 * Execution response success handler.
	 *
	 * @param  {String} res
	 *
	 * @return {Void}
	 */
	function responseDone (res) {
		console.log('response:', res);
		try {
			res = JSON.parse(res);
		} catch (e) {}
		$response.html(tmpl('output', res)).show();
		$controls.html(tmpl(typeof res === 'object' ? 'controls' : 'ended_unexpectedly', res));
		activate(!tabs.active || typeof res === 'string' || res.error ? tabs.initial : tabs.active);
		$response.imagesLoaded(resize);
	}

	/**
	 * Execution response failure handler.
	 *
	 * @param  {Object} res
	 *
	 * @return {Void}
	 */
	function responseFail (res) {
		console.log('fail:', res);
		var json;
		try {
			json = JSON.parse(res.responseText);
		} catch (e) {}
		$response.html(tmpl('output', json || res.responseText)).show();
		$controls.html(tmpl('controls_error' , res));
		activate(!tabs.active || typeof res === 'string' || res.error ? tabs.initial : tabs.active);
		$response.imagesLoaded(resize);
	}

	/**
	 * Activate a tab.
	 *
	 * @param  {String}  tab
	 * @param  {Boolean} force
	 *
	 * @return {Void}
	 */
	function activate (tab) {
		var $holders = $response.children();
		var $buttons = $controls.find('[data-show]');

		$buttons.removeClass(tabs.activeClass).filter('[data-show=' + tab + ']').addClass(tabs.activeClass);
		$holders.hide().filter('[data-tab=' + tab + ']').show();
		tabs.active = tab;
		resize();
	}

	/**
	 * Reset code view.
	 *
	 * @return {Void}
	 */
	function reset() {
		tabs.active = null;
		$response.hide().html('');
		$controls.html(tmpl('controls_intro', { checked: Modernizr.localstorage && localStorage.remember / 1 === 1 }));
		resize();
	}

	/**
	 * Resize sections.
	 *
	 * @return {Void}
	 */
	function resize() {
		var output_height = $response.is(':visible') ? $response.outerHeight() : 0;
		var newHeight = Math.round($console.outerHeight() - output_height - $controlbar.outerHeight());
		editor.setSize(null, newHeight);
		$editor.height(newHeight);
	}

	// Execution initiators
	$execute.on('click', function () {
		execute();
	});

	jwerty.key('ctrl+enter/cmd+enter', function () {
		execute();
	});

	// Toggle profiler tabs
	$controls.on('click', '[data-show]', function () {
		activate($(this).data('show'));
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
		if (Modernizr.localstorage && localStorage.remember / 1 === 1) {
			editor.setValue(localStorage.code);
			editor.setCursor(localStorage.line ? localStorage.line / 1 : 0, localStorage.char ? localStorage.char / 1 : 0);
		}

		$controls.on('click', '.remember .button', function () {
			var do_remember = localStorage.remember / 1 !== 1;
			var cursor = editor.getCursor();

			$(this)[do_remember ? 'addClass' : 'removeClass'](checked_class);

			if (do_remember) {
				localStorage.remember = 1;
				localStorage.code = editor.getValue();
				localStorage.line = cursor.line;
				localStorage.char = cursor.ch;
			} else {
				localStorage.clear();
			}

		})[localStorage.remember / 1 === 1 ? 'addClass' : 'removeClass'](checked_class);
	}

	// Initiate view reset
	reset();
});
