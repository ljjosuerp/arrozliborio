<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Arrocera Liborio') }}</title>

        {{-- SEO --}}
        <meta name="description" content="Arrocera Liborio — arroz, frijoles y aceite 100% costarricenses. De la pampa a tu mesa, apoyando al productor nacional.">
        <meta property="og:title" content="{{ config('app.name', 'Arrocera Liborio') }}">
        <meta property="og:description" content="Arroz, frijoles y aceite 100% costarricenses. De la pampa a tu mesa.">
        <meta property="og:type" content="website">
        <meta property="og:image" content="/img/liborio/logo-liborio-red.webp">
        <meta name="theme-color" content="#B2292E">
        <link rel="icon" type="image/png" href="/img/liborio/espiga-mark-red.webp">

        {{-- Google Tag Manager --}}
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MZXC5R8');</script>
        {{-- End Google Tag Manager --}}

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        {{-- Google Tag Manager (noscript) --}}
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZXC5R8"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        {{-- End Google Tag Manager (noscript) --}}

        @inertia
    </body>
</html>
