<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Agendamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AgendamentoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_agendar()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/agendar', [
            'data' => Carbon::tomorrow()->format('Y-m-d'),
            'tipo_peste' => 'Roedores'
        ]);

        $response->assertRedirect('/meus-agendamentos');
        $this->assertDatabaseHas('agendamentos', [
            'user_id' => $user->id,
            'data' => Carbon::tomorrow()->format('Y-m-d'),
            'tipo_peste' => 'Roedores',
            'status' => 'pendente'
        ]);
    }

    /** @test */
    public function nao_pode_agendar_em_data_passada()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $dataAgendada = Carbon::tomorrow()->format('Y-m-d');

        // Agendamento já existente
        Agendamento::create([
            'user_id' => $user->id,
            'data' => $dataAgendada,
            'status' => 'pendente',
            'tipo_peste' => 'Roedores'
        ]);

        $response = $this->post('/agendar', [
            'data' => $dataAgendada,
            'tipo_peste' => 'Outros'
        ]);

        $response->assertSessionHasErrors('data');
    }

    /** @test */
    public function agendamento_requer_data_valida()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/agendar', [
            'data' => '',
            'tipo_peste' => ''
        ]);

        $response->assertSessionHasErrors(['data', 'tipo_peste']);
    }
}
