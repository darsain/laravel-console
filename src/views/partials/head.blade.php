<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Laravel Console</title>
		<meta name="viewport" content="width=device-width">

		<link rel="stylesheet" href="{{ asset('vendor/darsain/console/css/normalize.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/darsain/console/css/main.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/darsain/console/css/codemirror.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/darsain/console/css/laravel.css') }}">

    <script>
      window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
      ]); ?>
    </script>
		<script src="{{ asset('vendor/darsain/console/js/vendor/modernizr.js') }}"></script>
	</head>
	<body>
