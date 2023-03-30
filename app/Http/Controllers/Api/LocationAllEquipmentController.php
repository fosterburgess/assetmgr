<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;

class LocationAllEquipmentController extends Controller
{
    public function index(
        Request $request,
        Location $location
    ): EquipmentCollection {
        $this->authorize('view', $location);

        $search = $request->get('search', '');

        $allEquipment = $location
            ->allEquipment()
            ->search($search)
            ->latest()
            ->paginate();

        return new EquipmentCollection($allEquipment);
    }

    public function store(
        Request $request,
        Location $location
    ): EquipmentResource {
        $this->authorize('create', Equipment::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'serial_number' => ['nullable', 'max:255', 'string'],
            'purchase_date' => ['nullable', 'date'],
            'metadata' => ['nullable', 'max:255', 'json'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $equipment = $location->allEquipment()->create($validated);

        return new EquipmentResource($equipment);
    }
}
