<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerCollection;

class ContactManufacturersController extends Controller
{
    public function index(
        Request $request,
        Contact $contact
    ): ManufacturerCollection {
        $this->authorize('view', $contact);

        $search = $request->get('search', '');

        $manufacturers = $contact
            ->manufacturers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ManufacturerCollection($manufacturers);
    }

    public function store(
        Request $request,
        Contact $contact,
        Manufacturer $manufacturer
    ): Response {
        $this->authorize('update', $contact);

        $contact->manufacturers()->syncWithoutDetaching([$manufacturer->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Contact $contact,
        Manufacturer $manufacturer
    ): Response {
        $this->authorize('update', $contact);

        $contact->manufacturers()->detach($manufacturer);

        return response()->noContent();
    }
}
