<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyCollection;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    public function index(Request $request): CompanyCollection
    {
        $this->authorize('view-any', Company::class);

        $search = $request->get('search', '');

        $companies = Company::search($search)
            ->latest()
            ->paginate();

        return new CompanyCollection($companies);
    }

    public function store(CompanyStoreRequest $request): CompanyResource
    {
        $this->authorize('create', Company::class);

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('public');
        }

        $company = Company::create($validated);

        return new CompanyResource($company);
    }

    public function show(Request $request, Company $company): CompanyResource
    {
        $this->authorize('view', $company);

        return new CompanyResource($company);
    }

    public function update(
        CompanyUpdateRequest $request,
        Company $company
    ): CompanyResource {
        $this->authorize('update', $company);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::delete($company->logo);
            }

            $validated['logo'] = $request->file('logo')->store('public');
        }

        $company->update($validated);

        return new CompanyResource($company);
    }

    public function destroy(Request $request, Company $company): Response
    {
        $this->authorize('delete', $company);

        if ($company->logo) {
            Storage::delete($company->logo);
        }

        $company->delete();

        return response()->noContent();
    }
}
