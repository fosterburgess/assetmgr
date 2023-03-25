<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;

class ManufacturerContactsController extends Controller
{
    public function index(
        Request $request,
        Manufacturer $manufacturer
    ): ContactCollection {
        $this->authorize('view', $manufacturer);

        $search = $request->get('search', '');

        $contacts = $manufacturer
            ->contacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContactCollection($contacts);
    }

    public function store(
        Request $request,
        Manufacturer $manufacturer,
        Contact $contact
    ): Response {
        $this->authorize('update', $manufacturer);

        $manufacturer->contacts()->syncWithoutDetaching([$contact->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Manufacturer $manufacturer,
        Contact $contact
    ): Response {
        $this->authorize('update', $manufacturer);

        $manufacturer->contacts()->detach($contact);

        return response()->noContent();
    }
}
