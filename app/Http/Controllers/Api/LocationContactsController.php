<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;

class LocationContactsController extends Controller
{
    public function index(
        Request $request,
        Location $location
    ): ContactCollection {
        $this->authorize('view', $location);

        $search = $request->get('search', '');

        $contacts = $location
            ->contacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContactCollection($contacts);
    }

    public function store(
        Request $request,
        Location $location,
        Contact $contact
    ): Response {
        $this->authorize('update', $location);

        $location->contacts()->syncWithoutDetaching([$contact->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Location $location,
        Contact $contact
    ): Response {
        $this->authorize('update', $location);

        $location->contacts()->detach($contact);

        return response()->noContent();
    }
}
