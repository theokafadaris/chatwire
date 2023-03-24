<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            /* Add your custom styles here */
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>@yield('title')</h1>
            </div>
            <div class="content">
                @yield('content')
            </div>
            <div class="footer">
                @yield('footer')
            </div>
        </div>
    </body>
</html>