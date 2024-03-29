<x-app-layout>
    <div
        class="grow flex flex-col md:translate-x-0 duration-300 ease-in-out"
        :class="profileSidebarOpen ? 'translate-x-1/3' : 'translate-x-0'"
    >

        <!-- Profile background -->
        <div class="relative h-56 bg-slate-200">
            <img class="object-cover h-full w-full"
                 src="https://zeed-live.nyc3.cdn.digitaloceanspaces.com/{{$user->accountDetail->cover_image}}"
                 width="979" height="220" alt="Profile background"/>
            <!-- Close button -->
            <button
                class="md:hidden absolute top-4 left-4 sm:left-6 text-white opacity-80 hover:opacity-100"
                @click.stop="profileSidebarOpen = !profileSidebarOpen"
                aria-controls="profile-sidebar"
                :aria-expanded="profileSidebarOpen"
            >
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"/>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="relative px-4 sm:px-6 pb-8">

            <!-- Pre-header -->
            <div class="-mt-16 mb-6 sm:mb-3">

                <div class="flex flex-col items-center sm:flex-row sm:justify-between sm:items-end">

                    <!-- Avatar -->
                    <div class="inline-flex -ml-1 -mt-1 mb-4 sm:mb-0">
                        <img class="rounded-full border-4 border-white"
                             src="https://zeed-live.nyc3.cdn.digitaloceanspaces.com/{{$user->accountDetail->profile_image}}"
                             width="128" height="128" alt="Avatar" style="object-fit: cover; height: 125px;"/>
                    </div>


                </div>

            </div>

            <!-- Header -->
            <header class="text-center sm:text-left mb-6">
                <!-- Name -->
                <div class="inline-flex items-start mb-2">
                    <h1 class="text-2xl text-slate-800 font-bold">{{ $user->name }}</h1>
                    <svg class="w-4 h-4 fill-current shrink-0 text-amber-500 ml-2" viewBox="0 0 16 16">
                        <path
                            d="M13 6a.75.75 0 0 1-.75-.75 1.5 1.5 0 0 0-1.5-1.5.75.75 0 1 1 0-1.5 1.5 1.5 0 0 0 1.5-1.5.75.75 0 1 1 1.5 0 1.5 1.5 0 0 0 1.5 1.5.75.75 0 1 1 0 1.5 1.5 1.5 0 0 0-1.5 1.5A.75.75 0 0 1 13 6ZM6 16a1 1 0 0 1-1-1 4 4 0 0 0-4-4 1 1 0 0 1 0-2 4 4 0 0 0 4-4 1 1 0 1 1 2 0 4 4 0 0 0 4 4 1 1 0 0 1 0 2 4 4 0 0 0-4 4 1 1 0 0 1-1 1Z"/>
                    </svg>
                </div>

            </header>

            <!-- Tabs -->
            <div class="relative mb-6">
                <div class="absolute bottom-0 w-full h-px bg-slate-200" aria-hidden="true"></div>
                <ul class="relative text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="block pb-3 text-indigo-500 whitespace-nowrap border-b-2 border-indigo-500 tab-link"
                           href="#general">General</a>
                    </li>
                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap tab-link"
                           href="#collections">Collections</a>
                    </li>
                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap tab-link"
                           href="#statistics">Statistics</a>
                    </li>
                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                        <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap tab-link"
                           href="#reviews">Reviews</a>
                    </li>
{{--                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">--}}
{{--                        <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap tab-link"--}}
{{--                           href="#orders">Orders</a>--}}
{{--                    </li>--}}
{{--                    <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">--}}
{{--                        <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap tab-link"--}}
{{--                           href="#offers">Offers</a>--}}
{{--                    </li>--}}
                </ul>
            </div>


            <!-- Sections -->
            <section id="general" class="tab-content">
                <div class="flex flex-col md:flex-row xl:flex-row xl:space-x-16">

                    <!-- Main content -->
                    <div class="space-y-5 mb-8 xl:mb-0">

                        <!-- About Me -->
                        <div>
                            <h2 class="text-slate-800 font-semibold mb-2">About</h2>
                            <div class="text-sm space-y-2">
                                <p>{{$user->accountDetail->description}}</p>
                            </div>
                        </div>


                    </div>

                    <!-- Sidebar -->
                    <aside class="xl:min-w-56 xl:w-56 space-y-3">
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Mobile</h3>
                            <div>{{$user->mobile}}</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Gender</h3>
                            <div>{{$user->gender}}</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Email</h3>
                            <div>{{$user->email}}</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Rank</h3>
                            <div>{{$user->rank}}</div>
                        </div>

                    </aside>

                </div>
            </section>

            <section id="collections" class="tab-content hidden">
                <div id="collectionsContainer">
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2"> {{$user->name}}'s Collections</h2>
                    @if($orders->count() == 0)
                        <div class="flex flex-col items-center justify-center">
                            <p class="text-gray-500 text-lg">No Collections Yet</p>
                        </div>
                    @endif
                    @foreach($collections as $collection)
                        <ul class="space-y-8 sm:space-y-5 my-6">
                            <!-- Related item -->
                            <li class="sm:flex items-center border-2 mt-1">
                                <a class="block mb-4 sm:mb-0 mr-5 md:w-32 xl:w-auto shrink-0" href="#0">
                                    <img class="rounded-sm" src="{{$collection->image}}" width="200" height="142"
                                         alt="Product 01"
                                         style="height: 120px; object-fit: contain; background: white"/>
                                </a>
                                <div class="grow">
                                    <a href="#0">
                                        <h3 class="text-lg font-semibold text-slate-800 mb-1 ml-2">{{$collection->title}}</h3>
                                    </a>
                                    <div class="text-sm mb-2 ml-2">{{$collection->description}}</div>

                                    <div class="flex flex-wrap items-center space-x-2 ml-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex space-x-1">
                                                <!-- view collection button -->
                                                <a class="btn-sm px-3 bg-white border-slate-200 hover:border-slate-300 text-slate-600"
                                                   href="{{ route('collection.show',$collection->id) }}">
                                                    <span>View Collection</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="text-slate-400">·</div>
                                        <!-- Price -->
                                        <div>
                                            <div
                                                class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">
                                                {{$collection->category->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <div class="mt-2">
                        {{ $collections->links() }}
                    </div>

                </div>
            </section>

            <section id="statistics" class="tab-content hidden">
                <div class="flex space-x-2 mb-2">
                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{$user->AuctualRate ?? 0}}<span class="ml-2">Rating</span>
                    </button>
                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{ $orders->count() }}<span class="ml-2">Orders</span>
                    </button>
                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{$user->collection}}<span class="ml-2">Collections</span>
                    </button>
                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{$user->follower}}<span class="ml-2">Followers</span>
                    </button>
                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                        {{$user->following}}<span class="ml-2">Following</span>
                    </button>
                </div>


                <!-- Order History -->
                <div>
                    <h2 class="text-slate-800 font-semibold mb-2">Order History</h2>
                    <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm">
                        @if($orders->count() == 0)
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-gray-500 text-lg">No Orders Yet</p>
                            </div>
                        @endif
                        @foreach($orders as $order)
                            <ul class="space-y-3">

                                <!-- Item -->
                                <li class="sm:flex sm:items-center sm:justify-between">
                                    <div class="sm:grow flex items-center text-sm">
                                        <!-- Icon -->
                                        <div class="w-8 h-8 rounded-full shrink-0 bg-amber-500 my-2 mr-3">
                                            <svg class="w-8 h-8 fill-current text-amber-50" viewBox="0 0 32 32">
                                                <path
                                                    d="M21 14a.75.75 0 0 1-.75-.75 1.5 1.5 0 0 0-1.5-1.5.75.75 0 1 1 0-1.5 1.5 1.5 0 0 0 1.5-1.5.75.75 0 1 1 1.5 0 1.5 1.5 0 0 0 1.5 1.5.75.75 0 1 1 0 1.5 1.5 1.5 0 0 0-1.5 1.5.75.75 0 0 1-.75.75Zm-7 10a1 1 0 0 1-1-1 4 4 0 0 0-4-4 1 1 0 0 1 0-2 4 4 0 0 0 4-4 1 1 0 0 1 2 0 4 4 0 0 0 4 4 1 1 0 0 1 0 2 4 4 0 0 0-4 4 1 1 0 0 1-1 1Z"/>
                                            </svg>
                                        </div>
                                        <!-- Position -->
                                        <div>
                                            <div class="font-medium text-slate-800">{{$order->lot->title}}</div>
                                            <div class="flex flex-nowrap items-center space-x-2 whitespace-nowrap">
                                                <div>Placed</div>
                                                <div class="text-slate-400">·</div>
                                                <div>{{$order->created_at->format('D j M, Y - g:i A')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tags -->
                                    <div class="sm:ml-2 mt-2 sm:mt-0">
                                        <ul class="flex flex-wrap sm:justify-end -m-1">
                                            <li class="m-1">
                                                <button
                                                    class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">{{$order->total_amount}}
                                                    SAR
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <hr>


                            </ul>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm mb-4 mt-2">
                    <h3 class="text-sm font-medium text-slate-800 mb-2">Offers Sent</h3>
                    <p class="text-sm">{{ $offers }} offers sent.</p>
                </div>
            </section>

            <section id="reviews" class="tab-content hidden">
                <!-- Reviews -->
                <div>
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Reviews ({{$user->rating->count()}}
                        )</h2>
                    @if($user->rating->count() == 0)
                        <div class="flex flex-col items-center justify-center">
                            <p class="text-gray-500 text-lg">No Reviews Yet</p>
                        </div>
                    @endif
                    @foreach($user->rating as $rating)
                        <ul class="space-y-5 my-6">
                            <!-- Review -->
                            <li>
                                <div class="flex items-center mb-2">
                                    <img class="w-8 h-8 rounded-full mr-3"
                                         src="{{$rating->user->accountDetail->profile_image ?? Null}}"
                                         width="32" height="32" alt="User 07"/>
                                    <div>
                                        <div
                                            class="text-sm font-semibold text-slate-800 mb-1">{{$rating->user->name}}</div>
                                        <!-- Rating -->
                                        <div class="flex items-center space-x-2">
                                            <!-- Stars -->
                                            <div class="flex space-x-1">
                                                @for($i = 0; $i < $rating->rating; $i++)
                                                    <svg class="w-4 h-4 fill-current text-amber-500"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 0l2.245 5.527 5.955.515-4.527 3.927 1.36 5.88L8 11.763l-5.033 3.086 1.36-5.88L.8 6.042l5.955-.515L8 0z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <!-- Rate -->
                                            <div class="text-sm text-slate-600">
                                                {{$rating->rating}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm italic">“{{$rating->comment}}”
                                </div>
                            </li>

                        </ul>

                    @endforeach

                </div>
            </section>

{{--            <section id="orders" class="tab-content hidden">--}}
{{--                <p>orders tab content</p>--}}
{{--            </section>--}}

{{--            <section id="offers" class="tab-content hidden">--}}
{{--                <p>offers tab content</p>--}}
{{--            </section>--}}


        </div>

    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        $('.tab-link').click(function (e) {
            e.preventDefault();
            // Remove 'active' class from all tab links
            $('.tab-link').removeClass('text-indigo-500 border-b-2 border-indigo-500');

            // Add 'border-b-2' and 'border-indigo-500' classes to the clicked tab link
            $(this).addClass('text-indigo-500 border-b-2 border-indigo-500');
            var targetSectionId = $(this).attr('href');
            $('.tab-content').hide();
            $(targetSectionId).show();
        });
    });
</script>


{{--<x-app-layout>--}}
{{--<div class="grow flex flex-col md:translate-x-0 duration-300 ease-in-out"--}}
{{--    :class="profileSidebarOpen ? 'translate-x-1/3' : 'translate-x-0'">--}}

{{--    <!-- Profile background -->--}}
{{--    <div class="relative h-56 bg-slate-200">--}}
{{--        <img class="object-cover h-full w-full" src="https://zeed-live.nyc3.cdn.digitaloceanspaces.com/{{$user->accountDetail->cover_image}}" width="979" height="220"--}}
{{--            alt="Profile background" style="object-fit: cover; height: 125px;" />--}}
{{--        <!-- Close button -->--}}
{{--        <button class="md:hidden absolute top-4 left-4 sm:left-6 text-white opacity-80 hover:opacity-100"--}}
{{--            @click.stop="profileSidebarOpen = !profileSidebarOpen" aria-controls="profile-sidebar"--}}
{{--            :aria-expanded="profileSidebarOpen">--}}
{{--            <span class="sr-only">Close sidebar</span>--}}
{{--            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />--}}
{{--            </svg>--}}
{{--        </button>--}}
{{--    </div>--}}

{{--    <!-- Content -->--}}
{{--    <div class="relative px-4 sm:px-6 pb-8">--}}

{{--        <!-- Pre-header -->--}}
{{--        <div class="-mt-16 mb-6 sm:mb-3">--}}

{{--            <div class="flex flex-col items-center sm:flex-row sm:justify-between sm:items-end">--}}

{{--                <!-- Avatar -->--}}
{{--                <div class="inline-flex -ml-1 -mt-1 mb-4 sm:mb-0">--}}
{{--                    <img class="rounded-full border-4 border-white"--}}
{{--                        src="https://zeed-live.nyc3.cdn.digitaloceanspaces.com/zeed/users/profile/{{$user->accountDetail->profile_image}}"--}}
{{--                        width="128" height="128" alt="Avatar" />--}}
{{--                </div>--}}

{{--                <!-- Actions -->--}}
{{--                <div class="flex space-x-2 sm:mb-2">--}}
{{--                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">--}}
{{--                        {{$user->AuctualRate}}<span class="ml-2">Rating</span>--}}
{{--                    </button>--}}
{{--                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">--}}
{{--                        {{ $orders->count() }}<span class="ml-2">Orders</span>--}}
{{--                    </button>--}}
{{--                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">--}}
{{--                        {{$user->collection}}<span class="ml-2">Collections</span>--}}
{{--                    </button>--}}
{{--                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">--}}
{{--                        {{$user->follower}}<span class="ml-2">Followers</span>--}}
{{--                    </button>--}}
{{--                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">--}}
{{--                        {{$user->following}}<span class="ml-2">Following</span>--}}
{{--                    </button>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--        <!-- Header -->--}}
{{--        <header class="text-center sm:text-left mb-6">--}}
{{--            <!-- Name -->--}}
{{--            <div class="inline-flex items-start mb-2">--}}
{{--                <h1 class="text-2xl text-slate-800 font-bold">{{$user->name}}</h1>--}}
{{--                <svg class="w-4 h-4 fill-current shrink-0 text-amber-500 ml-2" viewBox="0 0 16 16">--}}
{{--                    <path--}}
{{--                        d="M13 6a.75.75 0 0 1-.75-.75 1.5 1.5 0 0 0-1.5-1.5.75.75 0 1 1 0-1.5 1.5 1.5 0 0 0 1.5-1.5.75.75 0 1 1 1.5 0 1.5 1.5 0 0 0 1.5 1.5.75.75 0 1 1 0 1.5 1.5 1.5 0 0 0-1.5 1.5A.75.75 0 0 1 13 6ZM6 16a1 1 0 0 1-1-1 4 4 0 0 0-4-4 1 1 0 0 1 0-2 4 4 0 0 0 4-4 1 1 0 1 1 2 0 4 4 0 0 0 4 4 1 1 0 0 1 0 2 4 4 0 0 0-4 4 1 1 0 0 1-1 1Z" />--}}
{{--                </svg>--}}
{{--            </div>--}}

{{--        </header>--}}


{{--        <!-- Profile content -->--}}
{{--        <div class="flex flex-col xl:flex-row xl:space-x-16">--}}

{{--            <!-- Main content -->--}}
{{--            <div class="space-y-5 mb-8 xl:mb-0">--}}

{{--                <!-- About Me -->--}}
{{--                <div>--}}
{{--                    <h2 class="text-slate-800 font-semibold mb-2">About Me</h2>--}}
{{--                    <div class="text-sm space-y-2">--}}
{{--                        <p>{{$user->accountDetail->description}}</p>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Departments -->--}}
{{--         <div>--}}
{{--    <h2 class="text-slate-800 font-semibold mb-2">User Information</h2>--}}

{{--    <!-- User Products -->--}}
{{--    <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm mb-4">--}}
{{--        <h3 class="text-sm font-medium text-slate-800 mb-2">Products</h3>--}}
{{--        <ul class="text-sm">--}}
{{--            @foreach($products as $product)--}}
{{--            <li><a href="{{ route('product.show',$product->id ) }}">{{ $product->title }}</a></li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    <!-- Offers Sent -->--}}
{{--    <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm mb-4">--}}
{{--        <h3 class="text-sm font-medium text-slate-800 mb-2">Offers Sent</h3>--}}
{{--        <p class="text-sm">{{ $offers }} offers sent.</p>--}}
{{--    </div>--}}

{{--    <!-- Order History -->--}}
{{--    <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm mb-4">--}}
{{--        <h3 class="text-sm font-medium text-slate-800 mb-2">Order History</h3>--}}
{{--        <ul class="text-sm">--}}
{{--            @foreach($orders as $order)--}}
{{--            <li>Placed at {{ $order->created_at }} of Amount SAR {{ $order->total_amount }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    <!-- User Details -->--}}
{{--    <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm">--}}
{{--        <h3 class="text-sm font-medium text-slate-800 mb-2">User Details</h3>--}}
{{--        <p class="text-sm">{{ $user->name }}</p>--}}
{{--    </div>--}}
{{--</div>--}}


{{--            </div>--}}

{{--            <!-- Sidebar -->--}}
{{--            <aside class="xl:min-w-56 xl:w-56 space-y-3">--}}
{{--                <div class="text-sm">--}}
{{--                    <h3 class="font-medium text-slate-800">Mobile</h3>--}}
{{--                    <div>{{$user->mobile}}</div>--}}
{{--                </div>--}}
{{--                <div class="text-sm">--}}
{{--                    <h3 class="font-medium text-slate-800">Gender</h3>--}}
{{--                    <div>{{$user->gender}}</div>--}}
{{--                </div>--}}
{{--                <div class="text-sm">--}}
{{--                    <h3 class="font-medium text-slate-800">Email</h3>--}}
{{--                    <div>{{$user->email}}</div>--}}
{{--                </div>--}}
{{--                <div class="text-sm">--}}
{{--                    <h3 class="font-medium text-slate-800">Rank</h3>--}}
{{--                    <div>{{$user->rank}}</div>--}}
{{--                </div>--}}
{{--            </aside>--}}

{{--        </div>--}}

{{--    </div>--}}

{{--</div>--}}
{{--</x-app-layout>--}}
