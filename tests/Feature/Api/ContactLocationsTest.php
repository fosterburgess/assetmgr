<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Location;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactLocationsTest extends TestCase
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
    public function it_gets_contact_locations(): void
    {
        $contact = Contact::factory()->create();
        $location = Location::factory()->create();

        $contact->locations()->attach($location);

        $response = $this->getJson(
            route('api.contacts.locations.index', $contact)
        );

        $response->assertOk()->assertSee($location->name);
    }

    /**
     * @test
     */
    public function it_can_attach_locations_to_contact(): void
    {
        $contact = Contact::factory()->create();
        $location = Location::factory()->create();

        $response = $this->postJson(
            route('api.contacts.locations.store', [$contact, $location])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $contact
                ->locations()
                ->where('locations.id', $location->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_locations_from_contact(): void
    {
        $contact = Contact::factory()->create();
        $location = Location::factory()->create();

        $response = $this->deleteJson(
            route('api.contacts.locations.store', [$contact, $location])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $contact
                ->locations()
                ->where('locations.id', $location->id)
                ->exists()
        );
    }
}
