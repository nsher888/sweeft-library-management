<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @notifyCss
    @vite('resources/css/app.css')
</head>



<body {{ $attributes->merge(['class' => 'w-full min-h-screen static mx-auto'])
    }}>

    <x-notify::notify />

    {{ $slot }}


    @notifyJs
</body>

</html>