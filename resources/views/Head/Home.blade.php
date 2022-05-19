<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="//cdn.staticfile.org/vue/2.5.22/vue.min.js"></script>

    <script src="//cdn.staticfile.org/element-ui/2.14.1/index.min.js"></script>

    <script src="//cdn.bootcdn.net/ajax/libs/vue-router/3.0.1/vue-router.min.js"></script>

    <script src="//cdn.bootcdn.net/ajax/libs/axios/0.21.1/axios.min.js"></script>

{{--    <script src="//cdn.jsdelivr.net/npm/echarts@5.0.2/dist/echarts.min.js"></script>--}}
    <script src="{{ asset('js/echarts.js') }}"></script>

    <script src="//cdn.bootcdn.net/ajax/libs/less.js/3.13.0/less.min.js"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.staticfile.org/element-ui/2.14.1/theme-chalk/index.min.css">
        <script>
            window.postName= "{{ $name  }}"
            window.postId = "{{ $id }}"
            window.imagePath = "{{ env('ImagePath') }}"
        </script>
</head>
<body>
<div id="app"></div>
</body>
</html>
