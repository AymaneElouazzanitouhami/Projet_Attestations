<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an admin can view the login form.
     *
     * @return void
     */
    public function test_admin_can_view_login_form()
    {
        $response = $this->get('/administration/login');

        $response->assertSuccessful();
        $response->assertViewIs('admin.login');
    }

    /**
     * Test a successful admin login.
     *
     * @return void
     */
    public function test_admin_can_login_with_correct_credentials()
    {
        $admin = Administrateur::create([
            'nom' => 'Admin',
            'prenom' => 'User',
            'email' => 'admin@attesta.com',
            'mot_de_passe' => Hash::make('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@attesta.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /**
     * Test a failed admin login with incorrect credentials.
     *
     * @return void
     */
    public function test_admin_cannot_login_with_incorrect_credentials()
    {
        Administrateur::create([
            'nom' => 'Admin',
            'prenom' => 'User',
            'email' => 'admin@attesta.com',
            'mot_de_passe' => Hash::make('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@attesta.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('identification');
        $this->assertGuest('admin');
    }

    /**
     * Test validation when email is not provided.
     *
     * @return void
     */
    public function test_login_requires_an_email()
    {
        $response = $this->post(route('admin.login.submit'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test validation when password is not provided.
     *
     * @return void
     */
    public function test_login_requires_a_password()
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@attesta.com',
        ]);

        $response->assertSessionHasErrors('password');
    }
}