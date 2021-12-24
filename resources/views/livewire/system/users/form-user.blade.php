<div class="w-full">
    <x-loading wire:target="save, resend">
        <x-slot name="title">{{$title_loading}}</x-slot>
        Esto podria tardar un rato, por favor no cierres la página</x-loading>

    <form wire:submit.prevent="save" @table-users.window="open = 'table'">
        <div class="md:flex mb-8">
            <div class="md:w-1/3 flex-col md:space-y-2">
                <legend class="uppercase tracking-wide text-sm">{{__('User Data')}}</legend>
                <p class="text-xs font-light text-red">{{__('Info related at user')}}</p>
            </div>
            <div class="md:flex-1 mt-2 mb:mt-0 md:px-3 shadow-lg pb-4">
                <div class="grid gap-4">
                    {{-- User name --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="user_name">{{__('User name')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <input wire:model.defer="user.name" id="user_name" class="input block @error('user.name') border-error @enderror" type="text" placeholder="{{__('User name')}}" required />
                            @error('user.name')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
        
                    {{-- User email --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="user_email">{{__('User email')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <input wire:model.defer="user.email" id="user_email" class="input block @error('user.email') border-error @enderror" type="email" placeholder="{{__('User email')}}" required />
                            @error('user.email')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Profile Firstname --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="profile_firstname">{{__('Firstname')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <input wire:model.defer="profile.firstname" id="profile_firstname" class="input block @error('profile.firstname') border-error @enderror" type="text" placeholder="{{__('Firstname')}}" />
                            @error('profile.firstname')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
        
                    {{-- Profile Lastname --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="profile_lastname">{{__('Lastname')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <input wire:model.defer="profile.lastname" id="profile_lastname" class="input block @error('profile.lastname') border-error @enderror" type="text" placeholder="{{__('Lastname')}}" />
                            @error('profile.lastname')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
        
                    {{-- Profile Phone --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="profile_phone">{{__('Phone')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <input wire:model.defer="profile.phone" id="profile_phone" class="input block @error('profile.phone') border-error @enderror" type="text" placeholder="{{__('Phone')}}" />
                            @error('profile.phone')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
        
                    {{-- Select Role --}}
                    <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                        <label class="w-full md:w-1/3" for="select_role">{{__('Select Role')}}</label>
                        <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                            <select wire:model="role" id="select_role" class="text-dark bg-dark w-full rounded-md text-sm @error('role') border-error @enderror">
                                <option value="">{{__('Select')}}</option>
                                @foreach ($roles as $id => $rol)
                                    <option value="{{$id}}">{{$rol}}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="text-error">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:flex mb-8">
            <div class="md:w-1/3">
                <legend class="uppercase tracking-wide text-sm"></legend>
                <p class="text-xs font-light text-red"></p>
            </div>
            <div class="md:flex-1 mt-2 mb:mt-0 md:px-3">
                <div class="grid grid-cols-3">
                    <div class="hidden md:block col-span-1"></div>
                    <div class="col-span-3 md:col-span-2">
                        {{-- buttons --}}
                        <div class="flex items-center justify-between">
                            @if ( $type == 'new' )
                            <div class="">
                                <button class="btn-sm btn-primary">{{ __('Create User') }}</button>
                            </div>
                            @else
                            <div class="">
                                <button class="btn-sm btn-success">{{ __('Edit User') }}</button>
                            </div>
                            @endif
                            <button type="button" class="btn-sm btn-warning" wire:click="cancel">{{__('Cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ( $type == 'edit' )
        <div class="md:flex mb-8">
            <div class="md:w-1/3 flex-col md:space-y-2">
                <legend class="uppercase tracking-wide text-sm">{{__('Resend Password')}}</legend>
            </div>
            <div class="md:flex-1 mt-2 mb:mt-0 md:px-3 shadow-lg pb-4">
                <div class="grid gap-4">
                    <div class="flex justify-end">
                        <p class="text-xs font-light text-red">{{__('if the user forgot their password, you could be send a email with a link to page for change the password. This link is valid for one change.')}}</p>
                        <button type="button" class="btn-sm btn-primary whitespace-pre" wire:click="resend">{{ __('Send Link') }}</button>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
