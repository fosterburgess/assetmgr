<?php
namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCollection;

class CompanyContactsController extends Controller
{
    public function index(Request $request, Company $company): ContactCollection
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $contacts = $company
            ->contacts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContactCollection($contacts);
    }

    public function store(
        Request $request,
        Company $company,
        Contact $contact
    ): Response {
        $this->authorize('update', $company);

        $company->contacts()->syncWithoutDetaching([$contact->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Company $company,
        Contact $contact
    ): Response {
        $this->authorize('update', $company);

        $company->contacts()->detach($contact);

        return response()->noContent();
    }
}
