<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $this->authorize('view-any', Location::class);

        $search = $request->get('search', '');

        $locations = Location::search($search)
            ->where('owner_id', $user->id)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.locations.index', compact('locations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Location::class);

        return view('app.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationStoreRequest $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('create', Location::class);

        $validated = $request->validated();
        $validated['owner_id'] = $user->id;
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $location = Location::create($validated);

        return redirect()
            ->route('locations.edit', $location)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Location $location): View
    {
        $this->authorize('view', $location);

        return view('app.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Location $location): View
    {
        $this->authorize('update', $location);

        return view('app.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LocationUpdateRequest $request,
        Location $location
    ): RedirectResponse {
        $user = $request->user();
        $this->authorize('update', $location);

        $validated = $request->validated();
        $validated['owner_id'] = $user->id;
        if ($request->hasFile('logo')) {
            if ($location->logo) {
                Storage::delete($location->logo);
            }

            $validated['logo'] = $request->file('logo')->store('public');
        }

        $location->update($validated);

        return redirect()
            ->route('locations.edit', $location)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Location $location
    ): RedirectResponse {
        $this->authorize('delete', $location);

        if ($location->logo) {
            Storage::delete($location->logo);
        }

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
