<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyContactsDetail extends Component
{
    use AuthorizesRequests;

    public Company $company;
    public Contact $contact;
    public $contactsForSelect = [];
    public $contact_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Contact';

    protected $rules = [
        'contact_id' => ['required', 'exists:contacts,id'],
    ];

    public function mount(Company $company): void
    {
        $this->company = $company;
        $this->contactsForSelect = Contact::pluck('name', 'id');
        $this->resetContactData();
    }

    public function resetContactData(): void
    {
        $this->contact = new Contact();

        $this->contact_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newContact(): void
    {
        $this->modalTitle = trans('crud.company_contacts.new_title');
        $this->resetContactData();

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        $this->authorize('create', Contact::class);

        $this->company->contacts()->attach($this->contact_id, []);

        $this->hideModal();
    }

    public function detach($contact): void
    {
        $this->authorize('delete-any', Contact::class);

        $this->company->contacts()->detach($contact);

        $this->resetContactData();
    }

    public function render(): View
    {
        return view('livewire.company-contacts-detail', [
            'companyContacts' => $this->company
                ->contacts()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
