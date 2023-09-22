<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">

            <!-- Product Media Gallery -->
            <div class="w-full md:w-1/2 px-4 mb-4">
                <!-- Image Slider (you can use a library like Swiper.js) -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/product/images/' . $lot->image) }}" alt="Product Image" class="w-full h-auto rounded-lg shadow-lg">
                        </div>
                        <!-- Add more slides for additional images -->
                    </div>
                    <!-- Add pagination and navigation controls if needed -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <!-- Video Embed (you can use an iframe) -->
                <div class="mt-4">
                    <div class="relative">
                        <video controls width="100%" height="auto" class="rounded-lg shadow-lg">
                            <source src="{{ asset('images/product/videos/' . $lot->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Play Video
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="w-full md:w-1/2 px-4 mb-4">
                <!-- Seller Information -->
                <div class="mb-4">
                    <div class="flex items-center">
                        <img src="{{ asset($lot->auction->user->image) }}" alt="Seller Avatar" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold">{{ $lot->auction->user->name }}</h2>
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
                        <li>Condition: {{ $lot->condition }}</li>
                    </ul>
                </div>

                <!-- Add to Cart Button (or Bid Button) -->
            </div>
        </div>
    </div>
</x-app-layout>
