<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Location;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationContactsTest extends TestCase
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
    public function it_gets_location_contacts(): void
    {
        $location = Location::factory()->create();
        $contact = Contact::factory()->create();

        $location->contacts()->attach($contact);

        $response = $this->getJson(
            route('api.locations.contacts.index', $location)
        );

        $response->assertOk()->assertSee($contact->name);
    }

    /**
     * @test
     */
    public function it_can_attach_contacts_to_location(): void
    {
        $location = Location::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->postJson(
            route('api.locations.contacts.store', [$location, $contact])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $location
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_contacts_from_location(): void
    {
        $location = Location::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->deleteJson(
            route('api.locations.contacts.store', [$location, $contact])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $location
                ->contacts()
                ->where('contacts.id', $contact->id)
                ->exists()
        );
    }
}
