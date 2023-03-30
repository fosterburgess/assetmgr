<div class="grid grid-cols-4 gap-4">
    @can('view-any', Location::class)
    <div class="card w-64 bg-base-100">
        <div class="card-body">
            <h2 class="card-title">Locations</h2>
            <p>Manage your locations</p>
            <div class="card-actions justify-end">
                <a href="{{ route('locations.index') }}" class="rounded-md p-2 text-red-500">Manage</a>
            </div>
        </div>
    </div>
    @endcan
        @can('view-any', Equipment::class)
            <div class="card w-64 bg-base-100">
                <div class="card-body">
                    <h2 class="card-title">Equipment</h2>
                    <p>Manage your equipment</p>
                    <div class="card-actions justify-end">
                        <x-nav-link
                            href="{{ route('equipment.index') }}"
                        >
                            Manage
                        </x-nav-link>
                    </div>
                </div>
            </div>
        @endcan
</div>
