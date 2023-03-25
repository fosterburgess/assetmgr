<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;
use Illuminate\View\View;
use App\Models\Manufacturer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ManufacturerContactsDetail extends Component
{
    use AuthorizesRequests;

    public Manufacturer $manufacturer;
    public Contact $contact;
    public $contactsForSelect = [];
    public $contact_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Contact';

    protected $rules = [
        'contact_id' => ['required', 'exists:contacts,id'],
    ];

    public function mount(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
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
        $this->modalTitle = trans('crud.manufacturer_contacts.new_title');
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

        $this->manufacturer->contacts()->attach($this->contact_id, []);

        $this->hideModal();
    }

    public function detach($contact): void
    {
        $this->authorize('delete-any', Contact::class);

        $this->manufacturer->contacts()->detach($contact);

        $this->resetContactData();
    }

    public function render(): View
    {
        return view('livewire.manufacturer-contacts-detail', [
            'manufacturerContacts' => $this->manufacturer
                ->contacts()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
