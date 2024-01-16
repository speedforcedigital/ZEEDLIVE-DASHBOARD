<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- Page content -->
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">

            <!-- Content -->
            <div>
                <div class="mb-6">
                    <a class="btn-sm px-3 bg-white border-slate-200 hover:border-slate-300 text-slate-600"
                       href="{{route('collections.index')}}">
                        <svg class="fill-current text-slate-400 mr-2" width="7" height="12" viewBox="0 0 7 12">
                            <path d="M5.4.6 6.8 2l-4 4 4 4-1.4 1.4L0 6z"/>
                        </svg>
                        <span>Back To Collection</span>
                    </a>
                </div>
                <div class="text-sm font-semibold text-indigo-500 uppercase mb-2">

                    Created: {{ $collection->created_at->format('D j M, Y - g:i A') }}


                </div>
                <header class="mb-4">
                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2">{{ $collection->title }}</h1>
                </header>

                <!-- Meta -->
                <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
                    <!-- Author -->
                    <div class="flex items-center sm:mr-4">
                        <a class="block mr-2 shrink-0" href="#0">
                            <img class="rounded-full" src="{{ $collection->user->accountDetail->profile_image }}"
                                 width="32" height="32" alt="User 04" style="height: 30px; object-fit: cover"/>
                        </a>
                        <div class="text-sm whitespace-nowrap">Uploaded by <a class="font-semibold text-slate-800"
                                                                              href="{{ route('user.show',  $collection->user->id) }}">{{ $collection->user->name }}</a>
                        </div>
                    </div>

                </div>

                <!-- Image -->
                <figure class="mb-6">
                    <img class="w-full rounded-sm" src="{{ $collection->image }}" width="640" height="360"
                         style="width: 640px; height: 360px; object-fit: contain; background: white;"
                         alt="Meetup"/>
                </figure>

                <!-- Post content -->
                <div>
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Collection Description</h2>
                    <p class="mb-6">{{ $collection->description }}</p>

                </div>

                <hr class="my-6 border-t border-slate-200"/>

                <!-- Photos -->
                <div  id="collection-gallery">
                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Gallery images</h2>
                    <div class="grid grid-cols-3 gap-4 my-6">
                        @foreach($collection->gallery_images as $index => $image)
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
                    <div class="flex justify-between space-x-1 mb-5">
                        <div class="text-md text-slate-800 font-bold">Offers</div>

                    </div>
                    <ul class="space-y-3">
                        <div class="text-sm text-slate-800 font-semibold">Collection Offers</div>
                        @if(count($collection->offers) > 0)
                            @foreach($collection->offers as $offer)
                                <li class="border-b border-slate-200">
                                    <div class="flex justify-between">
                                        <div class="grow flex items-center">
                                            <div class="relative mr-3">
                                                <img class="w-8 h-8 rounded-full"
                                                     src="{{ $offer->user->accountDetail->profile_image }}"
                                                     width="32" height="32" alt="User 08"/>
                                            </div>
                                            <div class="truncate">
                                                <span
                                                    class="text-sm font-medium text-slate-800">{{ $offer->user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-slate-800 ml-2">{{ $offer->amount }}SAR
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <p class="mt-4">No offers in this collection.</p>
                        @endif
                    </ul>

                    <ul class="space-y-3 mt-2">
                        <div class="text-sm text-slate-800 font-semibold">Accepted Offers</div>
                        @if(count($collection->offers) > 0)
                            @foreach($collection->offers as $offer)
                                @if($offer->is_accepted == "1")
                                    <li class="border-b border-slate-200">
                                        <div class="flex justify-between">
                                            <div class="grow flex items-center">
                                                <div class="relative mr-3">
                                                    <img class="w-8 h-8 rounded-full"
                                                         src="{{ $offer->user->accountDetail->profile_image }}"
                                                         width="32" height="32" alt="User 08"/>
                                                </div>
                                                <div class="truncate">
                                                <span
                                                    class="text-sm font-medium text-slate-800">{{ $offer->user->name }}</span>
                                                </div>
                                            </div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">{{ $offer->amount }}SAR
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <p class="mt-4">No Accepted offer in this collection.</p>
                        @endif
                    </ul>
                </div>

                <!-- 3rd block -->
                <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                    <div class="flex justify-between space-x-1 mb-5">
                        <div class="text-sm text-slate-800 font-semibold">Additional Details</div>
                    </div>

                    <ul>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Category</div>
                            <div class="text-sm font-medium text-slate-800 ml-2">{{$collection->category->name}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Brand</div>
                            <div
                                class="text-sm font-medium text-slate-800 ml-2">{{$collection->brand->name ?? ''}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Model</div>
                            <div
                                class="text-sm font-medium text-slate-800 ml-2">{{$collection->model->name ?? ''}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Gender</div>
                            <div class="text-sm font-medium text-slate-800 ml-2">{{$collection->gender}}</div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Year</div>
                            <div class="flex items-center whitespace-nowrap">
                                {{--                                <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>--}}
                                <div class="text-sm font-medium text-slate-800">{{$collection->year}}</div>
                            </div>
                        </li>

                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Color</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$collection->color}}</div>
                            </div>
                        </li>

                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Condition</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$collection->condition}}</div>
                            </div>
                        </li>
                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                            <div class="text-sm">Appendices</div>
                            <div class="flex items-center whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800">{{$collection->appendices}}</div>
                            </div>
                        </li>
                        @foreach($customFields as $field)
                            <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                <div class="text-sm">{{$field['custom_field_title']}}</div>
                                <div class="flex items-center whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-800">{{$field['response']}}</div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>

<script type="module" src="{{asset('js/photoswipe.js')}}"></script>