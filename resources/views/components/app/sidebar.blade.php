<?php
$array = Session::get('permissions');
$keys = array();
$permissionsArray = json_decode($array, true);
if (is_array($permissionsArray)) {
    foreach ($permissionsArray as $element) {
        $keys = array_merge($keys, array_keys($element));
    }
    $keys = array_unique($keys);
//    dd($keys);
} else {
    $permissionsArray = array(); // Assign an empty array if $permissionsArray is null or not an array
}
?>
<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>

    <!-- Sidebar -->
    <div
        id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
        x-cloak="lg"
    >

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                <svg width="32" height="32" viewBox="0 0 32 32">
                    <defs>
                        <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                            <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                            <stop stop-color="#A5B4FC" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                            <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                            <stop stop-color="#38BDF8" offset="100%" />
                        </linearGradient>
                    </defs>
                    <rect fill="#6366F1" width="32" height="32" rx="16" />
                    <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
                    <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
                    <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">ZEEDLIVE</span>
                </h3>
                <ul class="mt-3">
                   <!-- Dashboard -->
                   @if(in_array('Dashboard', $keys))
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/dashboard">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif" d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif" d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-200' }}@else{{ 'text-slate-400' }}@endif" d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endif
                    <!-- Auctions -->
                    @if(in_array('Auction', $keys))
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/auctions">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                 <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['auctions'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['auctions'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif" d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['auctions'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Auctions</span>
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    @endif
                     @if(in_array('Auction', $keys))
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/products">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                 <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['products'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['products'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif" d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['products'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Products</span>
                                </div>
                            </div>
                        </a>
                    </li> --}}
                      <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['products'])){{  'bg-slate-900'  }}@endif" x-data="{ open: {{ in_array(Request::segment(1), ['products']) ? 1 : 0 }} }">
                          <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['products'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600" d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                        <path class="fill-current text-slate-400" d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Products</span>
                                </div>
                                <!-- Icon -->
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="{ 'hidden': !open }" x-cloak>
                            {{-- @if(in_array('Custom Field', $keys)) --}}
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="{{ route("standard.products") }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Standard Products</span>
                                        </a>
                                </li>
                                {{-- @endif --}}
                                {{-- @if(in_array('Global Field', $keys)) --}}
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="{{ route('livestream.products') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Live Stream Products</span>
                                        </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="{{ route('listings.products') }}">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Listings</span>
                                        </a>
                                </li>
                                {{-- @endif --}}
                            </ul>
                        </div>
                    </li>
                    @endif
                    <!-- Offers -->
                    @if(in_array('Offers', $keys))
                     <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="{{ route("collections.index") }}">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                 <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['collections'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['collections'])){{ 'text-indigo-600' }}@else{{ 'text-slate-700' }}@endif" d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['collections'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Collections</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/offers">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle class="fill-current @if(in_array(Request::segment(1), ['offers'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" cx="16" cy="8" r="8" />
                                        <circle class="fill-current @if(in_array(Request::segment(1), ['offers'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" cx="8" cy="16" r="8" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Offers</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/orders">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <circle class="fill-current @if(in_array(Request::segment(1), ['orders'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" cx="16" cy="8" r="8" />
                                        <circle class="fill-current @if(in_array(Request::segment(1), ['orders'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" cx="8" cy="16" r="8" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Orders</span>
                                </div>
                            </div>
                        </a>
                    </li>

                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/reported/orders">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                            <circle class="fill-current @if(in_array(Request::segment(1), ['reported/orders'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" cx="16" cy="8" r="8" />
                                            <circle class="fill-current @if(in_array(Request::segment(1), ['reported/orders'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" cx="8" cy="16" r="8" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reported Orders</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                    <!-- Dynamic Fields -->
                    @if(in_array('Custom Field', $keys) || in_array('Global Field', $keys))
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['custom','global'])){{  'bg-slate-900'  }}@endif" x-data="{ open: {{ in_array(Request::segment(1), ['custom','global']) ? 1 : 0 }} }">
                          <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['custom'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600" d="M19 5h1v14h-2V7.414L5.707 19.707 5 19H4V5h2v11.586L18.293 4.293 19 5Z" />
                                        <path class="fill-current text-slate-400" d="M5 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8ZM5 23a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm14 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dynamic Fields</span>
                                </div>
                                <!-- Icon -->
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="{ 'hidden': !open }" x-cloak>
                            @if(in_array('Custom Field', $keys))
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="/custom/fields">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Custom Fields</span>
                                        </a>
                                </li>
                                @endif
                                @if(in_array('Global Field', $keys))
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="/global/fields">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Global Fields</span>
                                        </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <!-- Messages -->
                    @endif
                    @if(in_array('Notifications', $keys))
                    {{-- <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/notifications">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600" d="M14.5 7c4.695 0 8.5 3.184 8.5 7.111 0 1.597-.638 3.067-1.7 4.253V23l-4.108-2.148a10 10 0 01-2.692.37c-4.695 0-8.5-3.184-8.5-7.11C6 10.183 9.805 7 14.5 7z" />
                                        <path class="fill-current text-slate-400" d="M11 1C5.477 1 1 4.582 1 9c0 1.797.75 3.45 2 4.785V19l4.833-2.416C8.829 16.85 9.892 17 11 17c5.523 0 10-3.582 10-8s-4.477-8-10-8z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Notifications</span>
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    @endif
                           @if(in_array('Admin User', $keys))
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/manage/category">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-6 w-6" viewBox="0 0 24 24" width="44" height="44"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4h6v6h-6z" />
                                        <path d="M14 4h6v6h-6z" />
                                        <path d="M4 14h6v6h-6z" />
                                        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Categories</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endif
                </ul>
            </div>
             <!-- Manage Categories/Brands/Models -->
            <div>
                    {{-- <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Management for Categories</span>
                    </h3> --}}
                    {{-- <ul class="">

                        <!-- Admin Users -->


                    </ul> --}}
                </div>
            <!-- More group -->
            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                </h3>
                <ul class="mt-3">
                    <!-- App Users -->
                    @if(in_array('App  User', $keys) || in_array('Seller Verification', $keys) || in_array('Wallets', $keys))
                     <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['sellers','users'])){{  'bg-slate-900'  }}@endif" x-data="{ open: {{ in_array(Request::segment(1), ['users','sellers']) ? 1 : 0 }} }">
                        <a class="block text-slate-200 hover:text-white transition duration-150" :class="open && 'hover:text-slate-200'" href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                       <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current @if(in_array(Request::segment(1), ['sellers','users'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                        <path class="fill-current @if(in_array(Request::segment(1), ['sellers','users'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">App Users</span>
                                </div>
                                <!-- Icon -->
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="{ 'hidden': !open }" x-cloak>
                            @if(in_array('App  User', $keys))
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="/users">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List</span>
                                        </a>
                                </li>
                                @endif
                                @if(in_array('Seller Verification', $keys))
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="/sellers">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Seller Verification</span>
                                        </a>
                                </li>
                                @endif
                                @if(in_array('Wallets', $keys))
                                <li class="mb-1 last:mb-0">
                                        <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate" href="/wallets">
                                            <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Wallets</span>
                                        </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    <!-- Admin Users -->
                    @if(in_array('Admin User', $keys))
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/admins">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-6 w-6" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path  stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Admin Users</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endif

                    @if(in_array('Admin User', $keys))
                        <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                            <a class="block text-slate-200 hover:text-white truncate transition duration-150" href="/roles">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 h-6 w-6" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path  stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                        <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Roles</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif

                    @endif

                </ul>
            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
