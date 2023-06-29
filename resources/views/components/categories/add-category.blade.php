<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->

    <div class="border-t border-slate-200">

        <!-- Components -->
        <div class="space-y-8 mt-8">

            <!-- Input Types -->
            <div>
                <div class="grid gap-5 md:grid-cols-3"> <!-- Changed to 3 columns -->

                    <div>
                        <!-- Start -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="category">Category <span class="text-rose-500">*</span></label>
                            <div class="flex">
                                <input id="category" class="form-input w-full" type="text" wire:model="category" required />
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addCategory">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                            </div>
                            @error('category')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <select size="7" class="custom-select mt-2" disabled>
                                <!-- Populate with categories from backend -->
                                <option>Category 1</option>
                                <option>Category 2</option>
                                <option>Category 3</option>
                            </select>
                        </div>
                        <!-- End -->
                    </div>

                    <div>
                        <!-- Start -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="brand">Brand <span class="text-rose-500">*</span></label>
                            <div class="flex">
                                <input id="brand" class="form-input w-full" type="text" wire:model="brand" required />
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addBrand">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                            </div>
                            @error('brand')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <select size="7" class="custom-select mt-2" disabled>
                                <!-- Populate with brands from backend -->
                                <option>Brand 1</option>
                                <option>Brand 2</option>
                                <option>Brand 3</option>
                            </select>
                        </div>
                        <!-- End -->
                    </div>

                    <div>
                        <!-- Start -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="model">Model <span class="text-rose-500">*</span></label>
                            <div class="flex">
                                <input id="model" class="form-input w-full" type="text" wire:model="model" required />
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addModel">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                            </div>
                            @error('model')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <select size="7" class="custom-select mt-2" disabled>
                                <!-- Populate with models from backend -->
                                <option>Model 1</option>
                                <option>Model 2</option>
                                <option>Model 3</option>
                            </select>
                        </div>
                        <!-- End -->
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
