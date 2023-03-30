<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;

class EquipmentController extends Controller
{
    public function index(Request $request): EquipmentCollection
    {
        $this->authorize('view-any', Equipment::class);

        $search = $request->get('search', '');

        $allEquipment = Equipment::search($search)
            ->latest()
            ->paginate();

        return new EquipmentCollection($allEquipment);
    }

    public function store(EquipmentStoreRequest $request): EquipmentResource
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validated();
        $validated['metadata'] = json_decode($validated['metadata'], true);

        $equipment = Equipment::create($validated);

        return new EquipmentResource($equipment);
    }

    public function show(
        Request $request,
        Equipment $equipment
    ): EquipmentResource {
        $this->authorize('view', $equipment);

        return new EquipmentResource($equipment);
    }

    public function update(
        EquipmentUpdateRequest $request,
        Equipment $equipment
    ): EquipmentResource {
        $this->authorize('update', $equipment);

        $validated = $request->validated();

        $validated['metadata'] = json_decode($validated['metadata'], true);

        $equipment->update($validated);

        return new EquipmentResource($equipment);
    }

    public function destroy(Request $request, Equipment $equipment): Response
    {
        $this->authorize('delete', $equipment);

        $equipment->delete();

        return response()->noContent();
    }
}
