<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="<?php echo url()->previous(); ?>"
               class="btn-sm text-white hover:text-white bg-indigo-600 hover:bg-indigo-800">
                <!-- back button icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                     width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="5" y1="12" x2="15" y2="12"/>
                    <line x1="5" y1="12" x2="9" y2="16"/>
                    <line x1="5" y1="12" x2="9" y2="8"/>
                </svg>
                <span>Back</span>
            </a>
        </div>
        <div class="flex flex-wrap -mx-4">

            <!-- Product Media Gallery -->
            <div class="w-full md:w-1/2 px-4 mb-4 ml-8">

                <div class="mb-4">
                    <h4 class="text-xl font-semibold mb-2">Collection Image</h4>
                    <img src="{{ $collection->image }}" alt="Product Image"
                         class="w-full h-56 object-none rounded-lg shadow-lg">
                </div>

                <div class="max-w-2xl mx-auto">
                    <h4 class="text-xl font-semibold mt-2">Gallery Images</h4>

                    <div id="default-carousel" class="relative" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
                            <!-- Item 1 -->
                            @foreach($collection->gallery_images as $image)
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <span
                                        class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                                    <img src="{{ $image->image }}" alt="Gallery Image"
                                         class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2">
                                </div>
                            @endforeach

                        </div>
                        <!-- Slider indicators -->
                        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                            @foreach($collection->gallery_images as $index => $image)
                                @php
                                    $isActive = ($index === 0);
                                @endphp
                                <button type="button"
                                        class="w-3 h-3 rounded-full {{ $isActive ? 'bg-blue-500' : 'bg-gray-300' }}"
                                        aria-current="{{ $isActive }}" aria-label="Slide {{ $index + 1 }}"
                                        data-carousel-slide-to="{{ $index }}"></button>
                            @endforeach
                        </div>
                        <!-- Slider controls -->
                        <button type="button"
                                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                                data-carousel-prev>
            <span
                class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-blue-500 dark:bg-gray-800/30 group-hover:bg-blue-800 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  stroke-width="2"
                                                                                  d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
                        </button>
                        <button type="button"
                                class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                                data-carousel-next>
            <span
                class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-blue-500 dark:bg-gray-800/30 group-hover:bg-blue-800 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  stroke-width="2"
                                                                                  d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
                        </button>
                    </div>


                </div>

            </div>


            <!-- Product Details -->
            <div
                class="bg-white dark:bg-slate-800 rounded-sm border border-slate-200 dark:border-slate-700 w-auto px-6 mb-4 ml-6">
                <!-- back button on right side -->

                <!-- Seller Information -->
                <div class="mb-4 mt-2">
                    <div class="flex items-center">
                        <img src="{{ $collection->user->accountDetail->profile_image }}" alt="Seller Avatar"
                             class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold"><a
                                    href="{{ route('user.show',  $collection->user->id) }}"> {{ $collection->user->name }} </a>
                            </h2>
                            <!-- Seller details -->
                        </div>
                    </div>
                </div>


                <!-- Title -->
                <h1 class="text-3xl font-semibold mb-4">{{ $collection->title }}</h1>

                <!-- Price -->
                <div class="border rounded-lg p-2.5 mb-3">
                    <!-- Bidding Details -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold mb-2">Offers</h2>
                        <!-- Displaying offers from the collection -->
                        @if(count($collection->offers) > 0)
                            <h3 class="mt-4 text-lg font-semibold">Collection Offers</h3>
                            <ul>
                                @foreach($collection->offers as $offer)
                                    <li class="mt-2">
                                        <p><strong>Offer Sender ID:</strong> {{ $offer->user->name }}</p>
                                        <p><strong>Amount:</strong> {{ $offer->amount }} SAR</p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-4">No offers in this collection.</p>
                        @endif
                        @if(count($collection->offers) > 0)
                            <h3 class="mt-4 text-lg font-semibold">Accepted Offers</h3>
                            <ul>
                                @foreach($collection->offers as $offer)
                                    @if($offer->is_accepted == "1")
                                        <li class="mt-2">
                                            <p><strong>Offer Sender ID:</strong> {{ $offer->user->name }}</p>
                                            <p><strong>Amount:</strong> {{ $offer->amount }} SAR</p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-4">No Accepted offer in this collection.</p>
                        @endif
                    </div>
                </div>
                <div class="border rounded-lg p-2.5 mb-3">
                    <!-- Product Description -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold mb-2">Collection Description</h2>
                        <p>{{ $collection->description }}</p>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="border rounded-lg p-2.5 mb-3">
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold mb-2">Additional Details</h2>
                        <ul>
                            <li>Gender: {{ $collection->gender }}</li>
                            <li>Year: {{ $collection->year }}</li>
                            <li>Color: {{ $collection->color }}</li>
                            <li>Condition: {{ $collection->condition }}</li>
                        </ul>
                    </div>
                </div>


                <!-- Add to Cart Button (or Bid Button) -->
            </div>

            <div class="w-full md:w-1/2 px-4 mb-4">
                {{--                                <div class="swiper-container gallery-slider mt-4">--}}
                {{--                                    <h4 class="text-xl font-semibold mb-2">Gallery Images</h4>--}}
                {{--                                    <div class="swiper-wrapper" style="height: 400px;">--}}
                {{--                                        @foreach($collection->gallery_images  as $image)--}}
                {{--                                            <div class="swiper-slide">--}}
                {{--                                                <img src="{{ $image->image }}" alt="Gallery Image" class="w-full h-full object-cover rounded-lg shadow-lg">--}}
                {{--                                            </div>--}}
                {{--                                        @endforeach--}}
                {{--                                    </div>--}}
                {{--                                    <!-- Add pagination and navigation controls if needed -->--}}
                {{--                                    <div class="slider-pagination"></div>--}}
                {{--                                    <div class="slider-button-next"></div>--}}
                {{--                                    <div class="slider-button-prev"></div>--}}
                {{--                                </div>--}}

                <!-- Video Embed (you can use an iframe) -->
                @if($collection->video)
                    <div class="mt-4">
                        <h4 class="text-xl font-semibold mb-2">Product Video</h4>
                        <div class="relative">
                            <video id="collectionVideo" controls width="100%" height="auto"
                                   class="rounded-lg shadow-lg">
                                <source src="{{ $collection->video }}" type="video/mp4">
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

                @endif
            </div>


        </div>
    </div>
</x-app-layout>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>

<script>
    // Get video element and play button
    const video = document.getElementById("collectionVideo");
    const playButton = document.getElementById("playButton");
    const playButtonContainer = document.getElementById("playButtonContainer");

    // Add click event listener to play button
    playButton.addEventListener("click", function () {
        // Play the video
        video.play();
        // Hide play button
        playButtonContainer.style.display = "none";
    });

    // Add event listener to pause event on the video
    video.addEventListener("pause", function () {
        // Show play button when video is paused
        playButtonContainer.style.display = "flex";
    });

    // Product Images Slider
    const productSwiper = new Swiper('.product-slider', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    // Gallery Images Slider
    const gallerySwiper = new Swiper('.gallery-slider', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.slider-button-next',
            prevEl: '.slider-button-prev',
        },
        pagination: {
            el: '.slider-pagination',
            clickable: true,
        },
    });
</script>
