<div>
    @if ( $role->exists )
    <h2 class="text-bse md:text-lg mb-4 text-center">{{$role->name}}</h2>
    @else
    <h2 class="text-bse md:text-lg mb-4 text-center">{{__('New Role')}}</h2>
    @endif
    <form wire:submit.prevent="save">
        <div class="w-full md:w-1/2 mx-auto" @table-roles.window="open = 'table'">
            @if ( $step == 1 )
            <div class="grid gap-4">
                {{-- Role name --}}
                <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                    <label class="w-full md:w-1/3" for="role_name">{{__('Role name')}}</label>
                    <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                        <input wire:model.defer="name" id="role_name" class="input block @error('name') border-error @enderror" type="text" placeholder="{{__('Role name')}}" required />
                        @error('name')
                            <div class="text-error">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- Display Name --}}
                <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                    <label class="w-full md:w-1/3" for="role_display_name">{{__('Display name')}}</label>
                    <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                        <input wire:model.defer="display_name" id="role_display_name" class="input block @error('display_name') border-error @enderror" type="text" placeholder="{{__('Display name')}}" required />
                        @error('display_name')
                            <div class="text-error">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                    <label class="w-full md:w-1/3" for="role_description">{{__('Description')}}</label>
                    <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                        <textarea wire:model.defer="description" id="role_description" class="input block @error('description') border-error @enderror" type="text" placeholder="{{__('Description')}}"></textarea>
                        @error('description')
                            <div class="text-error">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
            @if ( $step == 2 )
            <div class="grid gap-4">
                @foreach ($permissions as $group => $collection)
                <div class="my-2 overflow-hidden w-full dark:text-gray-200 text-gray-700">
                    <div class="w-full p-2 text-sm rounded-lg font-semibold dark:bg-gray-900 bg-gray-200">{{__(Str::title($group))}}</div>
                    <div class="grid grid-cols-2 gap-4 px-4">
                        @foreach ($collection as $id => $permission)
                        <div class="col-span-1 flex flex-col">
                            <label class="flex flex-row items-end mt-3">
                                <input wire:model.lazy="user_permissions.{{$id}}" id="permiso-{{$group}}-{{$id}}" type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" value="{{$permission->name}}">
                                    <span class="ml-2 text-sm">{{$permission->display_name}}</span>
                            </label>
                            <span class="mt-2 text-xs">{{$permission->description}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @error('user_permissions')
                    <div class="text-error">{{$message}}</div>
                @enderror
                @error('user_permissions.*')
                    <div class="text-error">{{$message}}</div>
                @enderror
            </div>
            @endif
            @if ( $step == 3 )
            <div class="grid gap-4">
                <div class="flex w-full">
                    <span class="w-1/3 md:text-lg">{{__('Role name')}}:</span>
                    <span class="font-bold">{{ $name }}</span>
                </div>
                <div class="flex w-full">
                    <span class="w-1/3 md:text-lg">{{__('Display name')}}:</span>
                    <span class="font-bold">{{ $display_name }}</span>
                </div>
                <div class="flex w-full">
                    <span class="w-1/3 md:text-lg">{{__('Description')}}:</span>
                    <span class="font-bold">{{ $description ?: '--' }}</span>
                </div>
                <div class="flex flex-col md:flex-row w-full items-center">
                    <span class="w-full md:w-1/3 md:text-lg">{{__('Permissions')}}:</span>
                    <span class="w-full md:w-2/3 mt-2 md:mt-0 text-sm">{{ $this->final_list() }}</span>
                </div>
                @if ( $type == "new")
                <div class="my-4 alert-info">
                    <div class="text-base md:text-lg font-bold text-center">¿Este seguro de querer crear este Cargo?</div>
                </div>
                @else
                <div class="my-4 alert-success">
                    <div class="text-base md:text-lg font-bold text-center">¿Este seguro de querer editar este Cargo?</div>
                </div>
                @endif
            </div>
            @endif
            <div class="mt-4 flex flex-col space-y-2 items-center">
                @if ( $step == 1 )
                <div class="flex justify-between items-center w-full">
                    <button type="button" class="btn-sm btn-warning" wire:click="cancel" id="cancel-1">{{__('Cancel')}}</button>
                    <button type="button" class="btn-sm btn-default" wire:click="step_add" id="add-1">{{__('Next')}}</button>
                </div>
                @endif
                @if ( $step == 2)
                <div class="flex justify-between items-center w-full">
                    <button type="button" class="btn-sm btn-default" wire:click="step_minus" id="back-2">{{__('Previous')}}</button>
                    <button type="button" class="btn-sm btn-warning" wire:click="cancel" id="cancel-2">{{__('Cancel')}}</button>
                    <button type="button" class="btn-sm btn-default" wire:click="step_add" id="add-2">{{__('Next')}}</button>
                </div>
                @endif
                @if ( $step == 3 )
                <div class="flex justify-between items-center w-full">
                    <button type="submit" class="btn-sm btn-primary">{{__('Save Role')}}</button>
                    <button type="button" class="btn-sm btn-default" wire:click="step_minus" id="back-3">{{__('Previous')}}</button>
                    <button type="button" class="btn-sm btn-warning" wire:click="cancel" id="cancel-3">{{__('Cancel')}}</button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>
