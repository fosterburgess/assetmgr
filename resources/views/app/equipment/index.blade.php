<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.equipment.index_title')
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a
                class="btn  btn-sm bg-blue-400 float-right"
                href="{{ route('equipment.create') }}"
            >
                New
            </a>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:equipment-table />
        </div>
    </div>
</x-app-layout>
