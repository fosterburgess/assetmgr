<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Manufacturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManufacturerContactsTest extends TestCase
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
    public function it_gets_manufacturer_contacts(): void
    {
        $manufacturer = Manufacturer::factory()->create();
        $contact = Contact::factory()->create();

        $manufacturer->contacts()->attach($contact);

        $response = $this->getJson(
            route('api.manufacturers.contacts.index', $manufacturer)
        );

        $response->assertOk()->assertSee($contact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_contacts_to_manufacturer(): void
    {
        $manufacturer = Manufacturer::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->postJson(
            route('api.manufacturers.contacts.store', [$manufacturer, $contact])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $manufacturer
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_contacts_from_manufacturer(): void
    {
        $manufacturer = Manufacturer::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->deleteJson(
            route('api.manufacturers.contacts.store', [$manufacturer, $contact])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $manufacturer
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }
}
