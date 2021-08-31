<!doctype html>
<html>
<head>
    @include('includes.head')
    @yield('head')
</head>
<body>
<div class="app">
    <header>
        @include('includes.header')
    </header>
    <div id="main">
        @yield('content')
    </div>
</div>
</body>
@yield('scripts')
</html>
