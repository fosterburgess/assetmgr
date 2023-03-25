<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactCompaniesTest extends TestCase
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
    public function it_gets_contact_companies(): void
    {
        $contact = Contact::factory()->create();
        $company = Company::factory()->create();

        $contact->companies()->attach($company);

        $response = $this->getJson(
            route('api.contacts.companies.index', $contact)
        );

        $response->assertOk()->assertSee($company->name);
    }

    /**
     * @test
     */
    public function it_can_attach_companies_to_contact(): void
    {
        $contact = Contact::factory()->create();
        $company = Company::factory()->create();

        $response = $this->postJson(
            route('api.contacts.companies.store', [$contact, $company])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $contact
                ->companies()
                ->where('companies.id', $company->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_companies_from_contact(): void
    {
        $contact = Contact::factory()->create();
        $company = Company::factory()->create();

        $response = $this->deleteJson(
            route('api.contacts.companies.store', [$contact, $company])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $contact
                ->companies()
                ->where('companies.id', $company->id)
                ->exists()
        );
    }
}
