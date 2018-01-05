<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="/assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/flat-admin.css">

    <style>
        .help-block, .has-error {
            color: #ff0000;
        }
    </style>

    @yield('styles')

</head>
<body>
<div class="app app-default">

    <div class="app-container app-login">
        <div class="flex-center">
            <div class="app-header"></div>
            <div class="app-body">
                @yield('content')
            </div>
            <div class="app-footer">
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script>
    $('div.alert').not('.alert-important').delay(5000).fadeOut(450);
</script>

@yield('scripts')
</body>
</html>