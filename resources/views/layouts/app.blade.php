<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css">



    <!-- Styles -->
    @livewireStyles

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<style>
    <
    style >
    .icon-tabler-check:hover {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-ban:hover {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-eye:hover {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-device-tv {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-player-stop {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-check {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-circle-plus {

        transform: scale(1.2);

        cursor: pointer;

    }

    .icon-tabler-id {

        transform: scale(1.2);

        cursor: pointer;

    }
</style>
<body
    class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
>
{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}

<script>
    if (localStorage.getItem('sidebar-expanded') == 'true') {
        document.querySelector('body').classList.add('sidebar-expanded');
    } else {
        document.querySelector('body').classList.remove('sidebar-expanded');
    }

</script>

<!-- Page wrapper -->
<div class="flex h-screen overflow-hidden">

    <x-app.sidebar/>

    <!-- Content area -->
    <div
        class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if($attributes['background']){{ $attributes['background'] }}@endif"
        x-ref="contentarea">

        <x-app.header/>

        <main class="grow">
            {{ $slot }}
        </main>

    </div>

</div>

@livewireScripts


</body>
</html>
