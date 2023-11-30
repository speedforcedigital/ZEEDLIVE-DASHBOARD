<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">

            <!-- Product Media Gallery -->
            <div class="w-full md:w-1/2 px-4 mb-4">
                <!-- Image Slider (you can use a library like Swiper.js) -->
                <div class="swiper-container product-slider">
                    <h4 class="text-xl font-semibold mb-2">Product Image</h4>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{  $lot->image  }}" alt="Product Image" class="w-3/4 h-auto rounded-lg shadow-lg">
                        </div>
                        <!-- Add more slides for additional images -->
                    </div>
                    <!-- Add pagination and navigation controls if needed -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <!-- Video Embed (you can use an iframe) -->
                @if($lot->video)
                <div class="mt-4">
                    <h4 class="text-xl font-semibold mb-2">Product Video</h4>
                    <div class="relative">
                        <video id="productVideo" controls width="100%" height="auto" class="rounded-lg shadow-lg">
                            <source src="{{ $lot->video }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div id="playButtonContainer" class="absolute inset-0 flex items-center justify-center">
                            <button id="playButton" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Play Video
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Gallery Images Slider -->

            </div>

            <!-- Product Details -->
            <div class="w-full md:w-1/2 px-4 mb-4">
                <!-- Seller Information -->
                <div class="mb-4">
                    <div class="flex items-center">
                        <img src="{{ $lot->auction->user->image }}" alt="Seller Avatar" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold">
                                <a href="{{ route('user.show', $lot->auction->user->id) }}">{{  $lot->auction->user->name }}</a>
                            </h2>
                            <!-- Seller details -->
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-semibold mb-4">{{ $lot->title }}</h1>

                <!-- Price -->
                <div class="text-2xl font-semibold text-green-600 mb-4">{{ $lot->price }} SAR</div>

                <!-- Bidding Details -->
                <div class="mb-4">
                    @if($lot->auction->type == 'Auction')
                        <p><strong>Starting Bid:</strong> {{ $lot->auction->auction_start_price }} SAR</p>
                    @endif
                    <p><strong>Current Bid:</strong> @if(count($lot->bids) > 0 ) {{$lot->bids->first()->amount }} SAR @else No Bids @endif </p>
                    <p><strong>Start Date:</strong> {{ $lot->auction->start_time }}</p>
                    <p><strong>End Date:</strong> {{ $lot->auction->end_time }}</p>
                </div>

                <!-- Product Description -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Product Description</h2>
                    <p>{{ $lot->description }}</p>
                </div>

                <!-- Additional Details -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Additional Details</h2>
                    <ul>
                        <li>Gender: {{ $lot->gender }}</li>
                        <li>Year: {{ $lot->year }}</li>
                        <li>Color: {{ $lot->color }}</li>
                        <li>Condition: {{ $lot->conditions }}</li>
                        <li>Appendices: {{ $lot->appendices }}</li>
                    </ul>
                </div>

                <!-- Add to Cart Button (or Bid Button) -->
            </div>
            <div class="w-full md:w-1/2 px-4 mb-4">
            <div class="swiper-container gallery-slider mt-4">
                <h4 class="text-xl font-semibold mb-2">Gallery Images</h4>
                <div class="swiper-wrapper" style="height: 400px;">
                    @foreach($lot->gallery_images as $image)
                        <div class="swiper-slide">
                            <img src="{{ $image->image }}" alt="Gallery Image" class="w-full h-full object-cover rounded-lg shadow-lg">
                        </div>
                    @endforeach
                </div>
                <!-- Add pagination and navigation controls if needed -->
                <div class="slider-pagination"></div>
                <div class="slider-button-next"></div>
                <div class="slider-button-prev"></div>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>

    var video = document.getElementById("productVideo");
    var playButton = document.getElementById("playButton");
    var playButtonContainer = document.getElementById("playButtonContainer");

    // Add click event listener to play button
    playButton.addEventListener("click", function() {
        // Play the video
        video.play();
        // Hide play button
        playButtonContainer.style.display = "none";
    });

    // Add event listener to pause event on the video
    video.addEventListener("pause", function() {
        // Show play button when video is paused
        playButtonContainer.style.display = "flex";
    });

    // Product Images Slider
    var productSwiper = new Swiper('.product-slider', {
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
    var gallerySwiper = new Swiper('.gallery-slider', {
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

