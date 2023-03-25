<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyCollection;

class ContactCompaniesController extends Controller
{
    public function index(Request $request, Contact $contact): CompanyCollection
    {
        $this->authorize('view', $contact);

        $search = $request->get('search', '');

        $companies = $contact
            ->companies()
            ->search($search)
            ->latest()
            ->paginate();

        return new CompanyCollection($companies);
    }

    public function store(
        Request $request,
        Contact $contact,
        Company $company
    ): Response {
        $this->authorize('update', $contact);

        $contact->companies()->syncWithoutDetaching([$company->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Contact $contact,
        Company $company
    ): Response {
        $this->authorize('update', $contact);

        $contact->companies()->detach($company);

        return response()->noContent();
    }
}
