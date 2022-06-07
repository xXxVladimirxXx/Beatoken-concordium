<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Beatoken</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="/assets/fonts/icons/css/beatoken.css" />
    <link rel="stylesheet" href="/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ mix('/assets/css/app.css') }}">
</head>
<body>
    <div id="beatoken-root"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&locale=en_US&currency=DKK"
        data-sdk-integration-source="button-factory"></script>
    <script src="{{ mix('/assets/js/app.js') }}"></script>
</body>
</html>
