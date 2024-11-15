<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.manufacturers.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('manufacturers.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.name')
                        </h5>
                        <span>{{ $manufacturer->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.description')
                        </h5>
                        <span>{{ $manufacturer->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.url1')
                        </h5>
                        <span>{{ $manufacturer->url1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.url2')
                        </h5>
                        <span>{{ $manufacturer->url2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.email')
                        </h5>
                        <span>{{ $manufacturer->email ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.manufacturers.inputs.phone')
                        </h5>
                        <span>{{ $manufacturer->phone ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('manufacturers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Manufacturer::class)
                    <a
                        href="{{ route('manufacturers.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\contact_manufacturer::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Contacts </x-slot>

                <livewire:manufacturer-contacts-detail
                    :manufacturer="$manufacturer"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
