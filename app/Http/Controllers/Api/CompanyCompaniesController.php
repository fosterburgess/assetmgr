<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;

class CompanyCompaniesController extends Controller
{
    public function index(Request $request, Company $company): CompanyCollection
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $companies = $company
            ->companies()
            ->search($search)
            ->latest()
            ->paginate();

        return new CompanyCollection($companies);
    }

    public function store(Request $request, Company $company): CompanyResource
    {
        $this->authorize('create', Company::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'image' => ['image', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $company = $company->companies()->create($validated);

        return new CompanyResource($company);
    }
}
