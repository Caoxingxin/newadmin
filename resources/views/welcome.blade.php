<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <!-- js -->
{{--        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>--}}

    </head>
    <body>
      <div id="app">
      </div>
      <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
