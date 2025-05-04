<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KategoriControllerTest extends TestCase
{

    // use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testStoreSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'id' => '1',
            'nama_kategori' => 'dessert',
        ];
        $response = $this->post('/kategori', $data);
        
        $response->assertStatus(302);

        $this->assertDatabaseHas('kategoris', $data);
    }
}
