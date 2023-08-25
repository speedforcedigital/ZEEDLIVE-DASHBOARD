<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->


        <div class="border-t border-slate-200">

            <!-- Components -->
            <div class="space-y-8 mt-8">

                <!-- Input Types -->
                <div>

                    <div class="grid gap-5 md:grid-cols-3">

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Title <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="custom_field_title" required />
                                @error('custom_field_title')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>
                <div>
                            <!-- Start -->
                        <label class="block text-sm font-medium mb-1" for="country">Category</label>
                        <select id="country" class="form-input w-full" wire:model="category_id">
                            <option value="">Select</option>
                            @foreach($this->categoryList as $category)
                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                           @endforeach
                        </select>
                        @error('category_id')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <!-- End -->
                </div>

                <div>
                            <!-- Start -->
                        <label class="block text-sm font-medium mb-1" for="country">Type</label>
                        <select id="country" class="form-input w-full" wire:model="type">
                            <option value="">Select</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="text">Text</option>
                        </select>
                        @error('type')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <!-- End -->
                </div>


                    @foreach ($this->fields as $index => $field)
                    <div>
                        <div>
                        <label class="block text-sm font-medium mb-1" for="country">Value {{$index + 1}}</label>
                            <input type="text" class="form-input w-full" wire:model="fields.{{ $index }}">
                            <button wire:click.prevent="removeField({{ $index }})" style="color:red">Remove</button>
                            @error('fields.' . $index) <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endforeach
                    <button wire:click.prevent="addField" style="font-size: large;font-weight: bold;">Add more</button>
            </div>
                <div class="grid gap-5 pt-0 float-right md:grid-cols-2">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div>
                    <input type="hidden" wire:model="custom_field_id">
                   <button wire:click="addCustomField()" wire:loading.class="opacity-50 cursor-wait" wire:target="addCustomField" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">

                    <span wire:loading wire:target="addCustomField"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <?= $this->updateMode ? 'Update Custom Field' : 'Add Custom Field' ?>
                    </span>
                </button>
               </div>

                </div>

                </div>

            </div>

        </div>

    </div>
