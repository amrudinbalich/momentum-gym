<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Return mock user.
     * @return User
     */
    public function mockUser(): User
    {
        return User::factory()->create([
            'name' => 'Dale',
            'email' => 'dale435@hotmail.com',
            'password' => Hash::make('NormalUserPW424')
        ]);
    }
    
    /**
     * Return mock admin user.
     * @return User
     */
    public function mockAdminUser(): User
    {
        return User::factory()->create([
            'name' => 'William',
            'email' => 'william@admin.com',
            'password' => Hash::make('AdminRuLes45'),
            'is_admin' => true
        ]);
    }

    /**
     * Act as normal user within the request.
     * @return void
     */
    public function actAsNormalUser(): void
    {
        $this->actingAs(
            $this->mockUser()
        );
    }

    /**
     * Act as admin within a request.
     * @return void
     */
    public function actAsAdminUser(): void
    {
        $this->actingAs(
            $this->mockAdminUser()
        );
    }
}
