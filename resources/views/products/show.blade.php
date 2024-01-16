<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- Page content -->
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">

            <!-- Content -->
            <div>
                <div class="mb-6">
                    <a class="btn-sm px-3 bg-white border-slate-200 hover:border-slate-300 text-slate-600"
                       href="{{route('standard.products')}}">
                        <svg class="fill-current text-slate-400 mr-2" width="7" height="12" viewBox="0 0 7 12">
                            <path d="M5.4.6 6.8 2l-4 4 4 4-1.4 1.4L0 6z"/>
                        </svg>
                        <span>Back To Products</span>
                    </a>
                </div>
                <div class="text-sm font-semibold text-indigo-500 uppercase mb-2">
                    Created: {{ $lot->created_at->format('D j M, Y - g:i A') }}
                </div>
                <header class="mb-4">
                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2">{{ $lot->title }}</h1>
                </header>

                <!-- Meta -->
                <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
                    <!-- Author -->
                    <div class="flex items-center sm:mr-4">
                        <a class="block mr-2 shrink-0" href="#0">
                            <img class="rounded-full" src="{{ $lot->auction->user->image }}"
                                 width="32" height="32" alt="User 04" style="height: 30px; object-fit: cover"/>
                        </a>
                        <div class="text-sm whitespace-nowrap">Uploaded by <a class="font-semibold text-slate-800" href="{{ route('user.show',  $lot->auction->user->id) }}">{{ $lot->auction->user->name }}</a>
                        </div>
                    </div>

                </div>

                <!-- Image -->
                <figure class="mb-6">
                    <img class="w-full rounded-sm" src="{{ $lot->image }}" width="640" height="360"
                         style="width: 640px; height: 360px; object-fit: contain; background: white;"
                         alt="Meetup"/>
                </figure>

                 <!-- @if($lot->video)
                    <div class="mt-4">
                        <h4 class="text-xl font-semibold mb-2">Product Video</h4>
                        <div class="relative">
                            <video id="productVideo" controls width="100%" height="auto" class="rounded-lg shadow-lg">
                                <source src="{{ $lot->video }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div id="playButtonContainer" class="absolute inset-0 flex items-center justify-center">
                                <button id="playButton"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                    Play Video
                                </button>
                            </div>
                        </div>
                    </div>
                @endif -->

                <!-- Post content -->
                <div>
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Lot Description</h2>
                    <p class="mb-6">{{ $lot->description }}</p>

                </div>

                <hr class="my-6 border-t border-slate-200"/>

                <!-- Photos -->
                <div  id="collection-gallery">
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Gallery images</h2>
                    <div class="grid grid-cols-3 gap-4 my-6">
                        @foreach($lot->gallery_images as $index => $image)
                            <a class="block" href="{{ $image->image }}" data-pswp-width="1875"
                               data-pswp-height="1900" target="_blank">
                                <img class="w-full rounded-sm" src="{{ $image->image }}" width="203" height="152"
                                     alt="Gallery Photo"
                                     style="height: 250px; object-fit: cover; object-position: center;">
                            </a>
                        @endforeach
                    </div>

                </div>
                <hr class="my-6 border-t border-slate-200"/>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- 2nd block -->
                <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                    @if($lot->auction->type == 'Auction')
                    <div class="flex justify-between space-x-1 mb-5">
                        <div class="text-md text-slate-800 font-bold">Auction Details</div>
                    </div>
                        <ul>
                            <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="text-sm">Starting Bid</div>
                                <div class="text-sm font-medium text-slate-800 ml-2">{{ number_format($lot->auction->auction_start_price, 0) }} SAR</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="text-sm">Current Bid</div>
                                <div class="text-sm font-medium text-slate-800 ml-2">
                                    @if(count($lot->bids) > 0)
                                        {{ number_format($lot->bids->first()->amount, 0) }} SAR
                                    @else
                                        No Bids
                                    @endif
                                </div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="text-sm">Start Date</div>
                                <div class="text-sm font-medium text-slate-800 ml-2">{{ $lot->auction->start_time }}</div>
                            </li>
                            <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="text-sm">End Date</div>
                                <div class="text-sm font-medium text-slate-800 ml-2">{{ $lot->auction->end_time }}</div>
                            </li>
                        </ul>
                    @endif
                </div>

                <!-- 3rd block -->
                <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                    <div class="flex justify-between space-x-1 mb-5">
                        <div class="text-sm text-slate-800 font-semibold">Additional Details</div>
                    </div>

                    <ul>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Category</div>
                            <div class="text-sm font-medium text-slate-800 ml-2">{{$lot->category->name}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Brand</div>
                            <div
                                class="text-sm font-medium text-slate-800 ml-2">{{$lot->brand->name ?? ''}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Model</div>
                            <div
                                class="text-sm font-medium text-slate-800 ml-2">{{$lot->model->name ?? ''}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Gender</div>
                            <div class="text-sm font-medium text-slate-800 ml-2">{{$lot->gender}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Year</div>
                            <div class="flex items-center whitespace-nowrap">
                                {{--                                <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>--}}
                                <div class="text-sm font-medium text-slate-800">{{$lot->year}}</div>
                            </div>
                        </li>

                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Color</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$lot->color}}</div>
                            </div>
                        </li>

                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Condition</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$lot->condition}}</div>
                            </div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Appendices</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$lot->appendices}}</div>
                            </div>
                        </li>
                        

                    </ul>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>

<script type="module" src="{{asset('js/photoswipe.js')}}"></script>