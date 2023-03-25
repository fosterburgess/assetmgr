<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Manufacturer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactManufacturersTest extends TestCase
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
    public function it_gets_contact_manufacturers(): void
    {
        $contact = Contact::factory()->create();
        $manufacturer = Manufacturer::factory()->create();

        $contact->manufacturers()->attach($manufacturer);

        $response = $this->getJson(
            route('api.contacts.manufacturers.index', $contact)
        );

        $response->assertOk()->assertSee($manufacturer->name);
    }

    /**
     * @test
     */
    public function it_can_attach_manufacturers_to_contact(): void
    {
        $contact = Contact::factory()->create();
        $manufacturer = Manufacturer::factory()->create();

        $response = $this->postJson(
            route('api.contacts.manufacturers.store', [$contact, $manufacturer])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $contact
                ->manufacturers()
                ->where('manufacturers.id', $manufacturer->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_manufacturers_from_contact(): void
    {
        $contact = Contact::factory()->create();
        $manufacturer = Manufacturer::factory()->create();

        $response = $this->deleteJson(
            route('api.contacts.manufacturers.store', [$contact, $manufacturer])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $contact
                ->manufacturers()
                ->where('manufacturers.id', $manufacturer->id)
                ->exists()
        );
    }
}
