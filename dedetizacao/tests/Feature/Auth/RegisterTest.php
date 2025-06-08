<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_se_cadastrar()
    {
        $response = $this->post('/register', [
            'name' => 'Guilherme',
            'email' => 'guilherme@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'address' => 'Rua das Flores, 123'
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'email' => 'guilherme@example.com'
        ]);
    }

    /** @test */
    public function cadastro_falha_com_dados_invalidos()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
            'address' => ''
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password'
        ]);
    }

    /** @test */
    public function usuario_nao_pode_cadastrar_com_email_ja_existente()
    {
        User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $response = $this->post('/register', [
            'name' => 'Outro Nome',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'address' => 'Rua das Palmeiras, 456'
        ]);

        $response->assertSessionHasErrors('email');
    }
}
