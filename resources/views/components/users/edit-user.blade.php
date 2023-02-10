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
                                <label class="block text-sm font-medium mb-1" for="mandatory">Name <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="name" required />
                                @error('name')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Email <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="email" wire:model="email" required />
                                @error('email')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Mobile <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="mobile" required />
                                @error('mobile')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Password <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="password" required />
                                @error('password')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>
                        
                    
                         <div>
                            <!-- Start -->
                        <label class="block text-sm font-medium mb-1" for="country">Gender</label>
                        <select id="country" class="form-input w-full" wire:model="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('gender')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                        <label class="block text-sm font-medium mb-1" for="country">User Role</label>
                        <select id="country" class="form-input w-full" wire:model="role">
                            <option value="">Select</option>
                            <option value="1">Admin</option>
                            <option value="2">Seller</option>
                            <option value="3">Buyer</option>
                        </select>
                        @error('role')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <!-- End -->
                        </div>
                   </div>

                <div class="grid gap-5 pt-0 float-right md:grid-cols-2">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div>
                   <input type="hidden" wire:model="user_id">
                   <button wire:click.prevent="update()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Update User</span>
                </button>
               </div>

                </div>
                   
                </div>

            </div>

        </div>

    </div>
