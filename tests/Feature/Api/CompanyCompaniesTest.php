<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyCompaniesTest extends TestCase
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
    public function it_gets_company_companies(): void
    {
        $company = Company::factory()->create();
        $companies = Company::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.companies.index', $company)
        );

        $response->assertOk()->assertSee($companies[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_companies(): void
    {
        $company = Company::factory()->create();
        $data = Company::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.companies.store', $company),
            $data
        );

        unset($data['owner_id']);
        unset($data['team_id']);
        unset($data['company_id']);

        $this->assertDatabaseHas('companies', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $company = Company::latest('id')->first();

        $this->assertEquals($company->id, $company->company_id);
    }
}
