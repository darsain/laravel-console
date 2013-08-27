<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Laravel Console</title>
		<meta name="viewport" content="width=device-width">
		
		{{ HTML::style('packages/darsain/console/css/normalize.css') }}
		{{ HTML::style('packages/darsain/console/css/main.css') }}
		{{ HTML::style('packages/darsain/console/css/codemirror/codemirror.css') }}
		{{ HTML::style('packages/darsain/console/css/codemirror/theme/'.Config::get('console.theme', Config::get('console::theme')).'.css') }}

		{{ HTML::script('packages/darsain/console/js/vendor/modernizr.js') }}

	</head>
	<body>
		<!--[if lt IE 9]>
			<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
		<![endif]-->