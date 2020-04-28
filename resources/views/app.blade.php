<!DOCTYPE html>
<html class="h-full background-primary">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    {{-- Inertia --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer>
    </script>

    {{-- Ping CRM --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>

    @routes


    {{-- Trix Assets --}}
    @if (in_array(request()->route()->getName(), ['messageBoards.create']))
    <script>
        window.csrf = @json(csrf_token())
    </script>
    @trixassets
    @endif

    <script src="{{ mix('/js/app.js') }}" defer></script>

</head>

<body class="font-sans leading-none text-primary antialiased">
    @inertia
</body>

</html>
