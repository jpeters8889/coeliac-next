<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <meta name="author" content="Coeliac Sanctuary"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="google-site-verification" content="MkXdbyO1KF2xCS7VFkP7v5ZaWw3WObMUJDFxX0z7_4w"/>

    <meta property="article:publisher" content="https://www.facebook.com/CoeliacSanctuary"/>
    <meta property="og:updated_time" content="{{ date('c') }}"/>

    <link href="/assets/images/apple/apple-touch-icon-57x57.png" rel="apple-touch-icon"/>
    <link href="/assets/images/apple/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72"/>
    <link href="/assets/images/apple/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
    <link href="/assets/images/apple/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5PWV6VHY13"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-5PWV6VHY13'); // GA-4
    </script>

    @vite('resources/js/app.ts')
    @inertiaHead
</head>
<body>
@inertia
@if(app()->isLocal())
    <div class="fixed bottom-0 right-0 bg-red text-white text-xs font-semibold leading-0 p-1">
        <span class="xxs:hidden">xxxs</span>
        <span class="hidden xxs:block xs:hidden">xxs</span>
        <span class="hidden xs:block sm:hidden">xs</span>
        <span class="hidden sm:block md:hidden">sm</span>
        <span class="hidden md:block xmd:hidden">md</span>
        <span class="hidden xmd:block lg:hidden">xmd</span>
        <span class="hidden lg:block xl:hidden">lg</span>
        <span class="hidden xl:block 2xl:hidden">xl</span>
        <span class="hidden 2xl:block">2xl</span>
    </div>
@endif
</body>
</html>
