<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">

            <!-- Product Media Gallery -->
            <div class="w-full md:w-1/2 px-4 mb-4">
                <!-- Image Slider (you can use a library like Swiper.js) -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/collections/images/' . $collection->image) }}" alt="Product Image" class="w-full h-auto rounded-lg shadow-lg">
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
                            <source src="{{ asset('images/collections/videos/' . $collection->video) }}" type="video/mp4">
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
                        <img src="{{ asset($collection->user->image) }}" alt="Seller Avatar" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold"><a href="{{ route('user.show',  $collection->user->id) }}"> {{ $collection->user->name }} </a></h2>
                            <!-- Seller details -->
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-semibold mb-4">{{ $collection->title }}</h1>

                <!-- Price -->

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

                <!-- Product Description -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Collection Description</h2>
                    <p>{{ $collection->description }}</p>
                </div>

                <!-- Additional Details -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Additional Details</h2>
                    <ul>
                        <li>Gender: {{ $collection->gender }}</li>
                        <li>Year: {{ $collection->year }}</li>
                        <li>Color: {{ $collection->color }}</li>
                        <li>Condition: {{ $collection->condition }}</li>
                    </ul>
                </div>

                <!-- Add to Cart Button (or Bid Button) -->
            </div>
        </div>
    </div>
</x-app-layout>
