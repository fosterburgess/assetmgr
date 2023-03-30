<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationCollection;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;

class LocationController extends Controller
{
    public function index(Request $request): LocationCollection
    {
        $this->authorize('view-any', Location::class);

        $search = $request->get('search', '');

        $locations = Location::search($search)
            ->latest()
            ->paginate();

        return new LocationCollection($locations);
    }

    public function store(LocationStoreRequest $request): LocationResource
    {
        $this->authorize('create', Location::class);

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $location = Location::create($validated);

        return new LocationResource($location);
    }

    public function show(Request $request, Location $location): LocationResource
    {
        $this->authorize('view', $location);

        return new LocationResource($location);
    }

    public function update(
        LocationUpdateRequest $request,
        Location $location
    ): LocationResource {
        $this->authorize('update', $location);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($location->logo) {
                Storage::delete($location->logo);
            }

            $validated['logo'] = $request->file('logo')->store('public');
        }

        $location->update($validated);

        return new LocationResource($location);
    }

    public function destroy(Request $request, Location $location): Response
    {
        $this->authorize('delete', $location);

        if ($location->logo) {
            Storage::delete($location->logo);
        }

        $location->delete();

        return response()->noContent();
    }
}
