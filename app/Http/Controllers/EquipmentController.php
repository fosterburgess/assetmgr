<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Location;
use App\Models\Manufacturer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Equipment::class);

        $search = $request->get('search', '');

        $allEquipment = Equipment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.equipment.index',
            compact('allEquipment', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $user = $request->user();
        $this->authorize('create', Equipment::class);
        $manufacturers = Manufacturer::all();
        $locations = Location::where('owner_id', $user->id)->get();

        return view('app.equipment.create', compact('locations', 'manufacturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validated();
        $validated['metadata'] = json_decode($validated['metadata'] ?? '', true);

        $equipment = Equipment::create($validated);

        return redirect()
            ->route('equipment.edit', $equipment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        return view('app.equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Equipment $equipment): View
    {
        $user = $request->user();
        $this->authorize('update', $equipment);

        $manufacturers = Manufacturer::all();
        $locations = Location::where('owner_id', $user->id)->get();

        return view('app.equipment.edit', compact('locations', 'manufacturers', 'equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EquipmentUpdateRequest $request,
        Equipment $equipment
    ): RedirectResponse {
        $this->authorize('update', $equipment);

        $validated = $request->validated();
        $validated['metadata'] = json_decode($validated['metadata'] ?? '', true);

        $equipment->update($validated);

        return redirect()
            ->route('equipment.edit', $equipment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Equipment $equipment
    ): RedirectResponse {
        $this->authorize('delete', $equipment);

        $equipment->delete();

        return redirect()
            ->route('equipment.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
