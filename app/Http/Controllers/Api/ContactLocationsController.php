<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCollection;

class ContactLocationsController extends Controller
{
    public function index(
        Request $request,
        Contact $contact
    ): LocationCollection {
        $this->authorize('view', $contact);

        $search = $request->get('search', '');

        $locations = $contact
            ->locations()
            ->search($search)
            ->latest()
            ->paginate();

        return new LocationCollection($locations);
    }

    public function store(
        Request $request,
        Contact $contact,
        Location $location
    ): Response {
        $this->authorize('update', $contact);

        $contact->locations()->syncWithoutDetaching([$location->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Contact $contact,
        Location $location
    ): Response {
        $this->authorize('update', $contact);

        $contact->locations()->detach($location);

        return response()->noContent();
    }
}
