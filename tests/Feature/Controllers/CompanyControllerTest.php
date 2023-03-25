<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_companies(): void
    {
        $companies = Company::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('companies.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.companies.index')
            ->assertViewHas('companies');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_company(): void
    {
        $response = $this->get(route('companies.create'));

        $response->assertOk()->assertViewIs('app.companies.create');
    }

    /**
     * @test
     */
    public function it_stores_the_company(): void
    {
        $data = Company::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('companies.store'), $data);

        unset($data['owner_id']);
        unset($data['team_id']);
        unset($data['country']);
        unset($data['notes']);

        $this->assertDatabaseHas('companies', $data);

        $company = Company::latest('id')->first();

        $response->assertRedirect(route('companies.edit', $company));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->get(route('companies.show', $company));

        $response
            ->assertOk()
            ->assertViewIs('app.companies.show')
            ->assertViewHas('company');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->get(route('companies.edit', $company));

        $response
            ->assertOk()
            ->assertViewIs('app.companies.edit')
            ->assertViewHas('company');
    }

    /**
     * @test
     */
    public function it_updates_the_company(): void
    {
        $company = Company::factory()->create();

        $user = User::factory()->create();

        $data = [
            'team_id' => $this->faker->randomNumber,
            'name' => $this->faker->name(),
            'logo' => $this->faker->word,
            'address1' => $this->faker->address,
            'address2' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'notes' => $this->faker->text,
            'url1' => $this->faker->url,
            'url2' => $this->faker->text(255),
            'url3' => $this->faker->url,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'owner_id' => $user->id,
        ];

        $response = $this->put(route('companies.update', $company), $data);

        unset($data['owner_id']);
        unset($data['team_id']);
        unset($data['country']);
        unset($data['notes']);

        $data['id'] = $company->id;

        $this->assertDatabaseHas('companies', $data);

        $response->assertRedirect(route('companies.edit', $company));
    }

    /**
     * @test
     */
    public function it_deletes_the_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));

        $this->assertSoftDeleted($company);
    }
}
