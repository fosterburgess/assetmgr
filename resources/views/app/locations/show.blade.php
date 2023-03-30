<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.companies.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('locations.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.name')
                        </h5>
                        <span>{{ $location->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.logo')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $location->logo ? \Storage::url($location->logo) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.address1')
                        </h5>
                        <span>{{ $location->address1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.address2')
                        </h5>
                        <span>{{ $location->address2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.city')
                        </h5>
                        <span>{{ $location->city ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.state')
                        </h5>
                        <span>{{ $location->state ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.postal_code')
                        </h5>
                        <span>{{ $location->postal_code ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.url1')
                        </h5>
                        <span>{{ $location->url1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.url2')
                        </h5>
                        <span>{{ $location->url2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.url3')
                        </h5>
                        <span>{{ $location->url3 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.email')
                        </h5>
                        <span>{{ $location->email ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.companies.inputs.phone')
                        </h5>
                        <span>{{ $location->phone ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('locations.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Location::class)
                    <a href="{{ route('locations.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\company_contact::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Contacts </x-slot>

                <livewire:company-contacts-detail :location="$location" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
