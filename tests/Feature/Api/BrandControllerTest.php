<?php

namespace Tests\Feature\Api;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{ 
    // -------------------------------------------------------------------------
    // INDEX
    // -------------------------------------------------------------------------
 
    /** @test */
    public function test_it_returns_a_paginated_list_of_brands(): void
    {
        Brand::factory()->count(5)->create();
 
        $response = $this->getJson(route('brands.index'));
 
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id']],
                'links',
                'meta',
            ]);
    }
 
    /** @test */
    public function test_index_respects_per_page_query_parameter(): void
    {
        Brand::factory()->count(20)->create();
 
        $response = $this->getJson(route('brands.index', [
            'per_page' => 5
        ]));
 
        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }
 
    /** @test */
    public function test_index_caps_per_page_at_100(): void
    {
        Brand::factory()->count(10)->create();
 
        // Even if someone requests 999, we should only get at most 100
        $response = $this->getJson(route('brands.index', [
            'per_page' => 999
        ]));
 
        $response->assertOk();
 
        $perPage = $response->json('meta.per_page');
        $this->assertLessThanOrEqual(100, $perPage);
    }
 
    // -------------------------------------------------------------------------
    // STORE
    // -------------------------------------------------------------------------

    /** @test */
    public function test_can_normal_user_make_entity(): void
    {
        $this->actAsNormalUser();

        $response = $this->postJson(route('brands.store'), []);
        $response->assertForbidden();
    }
 
    /** @test */
    public function test_it_creates_a_brand_with_valid_data(): void
    {
        $this->actAsAdminUser();
        $payload = Brand::factory()->make()->toArray();
 
        $response = $this->postJson(route('brands.store'), $payload);
 
        $response->assertCreated()
            ->assertJsonFragment(['message' => 'Brand created successfully.'])
            ->assertJsonStructure(['message', 'data' => ['id']]);
 
        $this->assertDatabaseHas('brands', ['name' => $payload['name']]);
    }
 
    /** @test */
    public function test_store_returns_422_when_required_fields_are_missing(): void
    {
        $this->actAsAdminUser();

        $response = $this->postJson(route('brands.store'), []);
 
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
 
    // -------------------------------------------------------------------------
    // SHOW
    // -------------------------------------------------------------------------
 
    /** @test */
    public function test_it_returns_a_single_brand(): void
    {
        $brand = Brand::factory()->create();
 
        $response = $this->getJson(route('brands.show', $brand));
 
        $response->assertOk()
            ->assertJsonStructure(['data' => ['id']])
            ->assertJsonPath('data.id', $brand->id);
    }
 
    /** @test */
    public function test_show_returns_404_for_non_existent_brand(): void
    {
        $response = $this->getJson(route('brands.show', ['brand' => 'Random']));
 
        $response->assertNotFound();
    }
 
    // -------------------------------------------------------------------------
    // UPDATE
    // -------------------------------------------------------------------------
 
    /** @test */
    public function test_it_updates_a_brand_with_valid_data(): void
    {
        $this->actAsAdminUser();

        $brand = Brand::factory()->create(['name' => 'Old Name']);
 
        $response = $this->putJson(route('brands.update', $brand), [
            'name' => 'New Name'
        ]);
 
        $response->assertOk()
            ->assertJsonFragment(['message' => 'Brand updated successfully.'])
            ->assertJsonPath('data.name', 'New Name');
 
        $this->assertDatabaseHas('brands', [
            'id'   => $brand->id,
            'name' => 'New Name',
        ]);
    }
 
    /** @test */
    public function test_update_returns_404_for_non_existent_brand(): void
    {
        $response = $this->putJson('/api/brands/99999', ['name' => 'Ghost Brand']);
 
        $response->assertNotFound();
    }
 
    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------
 
    /** @test */
    public function test_it_deletes_a_brand(): void
    {
        $this->actAsAdminUser();
        $brand = Brand::factory()->create();
 
        $response = $this->deleteJson(route('brands.destroy', $brand));
 
        $response->assertOk()
            ->assertJsonFragment(['message' => 'Brand deleted successfully.']);
 
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
 
    /** @test */
    public function test_destroy_returns_404_for_non_existent_brand(): void
    {
        $this->actAsAdminUser();
        $response = $this->deleteJson(route('brands.destroy', ['brand' => 'non-existent-slug']));
 
        $response->assertNotFound();
    }
}