<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyContactsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_company_contacts(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create();

        $company->contacts()->attach($contact);

        $response = $this->getJson(
            route('api.companies.contacts.index', $company)
        );

        $response->assertOk()->assertSee($contact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_contacts_to_company(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->postJson(
            route('api.companies.contacts.store', [$company, $contact])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $company
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_contacts_from_company(): void
    {
        $company = Company::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->deleteJson(
            route('api.companies.contacts.store', [$company, $contact])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $company
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }
}
