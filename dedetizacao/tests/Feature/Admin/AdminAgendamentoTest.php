<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Agendamento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAgendamentoTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;
    protected Agendamento $agendamento;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->regularUser = User::factory()->create();
        
        $this->agendamento = Agendamento::factory()->create([
            'user_id' => $this->regularUser->id,
            'data' => now()->addDay()->format('Y-m-d'),
            'status' => 'pendente',
            'tipo_peste' => 'roedores'
        ]);
    }

    /** @test */
    public function admin_index_retorna_view_com_agendamentos()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get('/admin');

        $response->assertStatus(200)
            ->assertViewIs('admin.index')
            ->assertViewHas('agendamentos')
            ->assertSee($this->agendamento->user->name);
    }

    /** @test */
    public function admin_pode_confirmar_agendamento()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post("/admin/confirmar/{$this->agendamento->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('agendamentos', [
            'id' => $this->agendamento->id,
            'status' => 'confirmado'
        ]);
    }

    /** @test */
    public function admin_pode_cancelar_agendamento()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post("/admin/cancelar/{$this->agendamento->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('agendamentos', [
            'id' => $this->agendamento->id,
            'status' => 'cancelado'
        ]);
    }

    /** @test */
    public function admin_pode_editar_agendamento()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get("/admin/editar/{$this->agendamento->id}");

        $response->assertStatus(200)
            ->assertViewIs('admin.edit')
            ->assertViewHas('agendamento', $this->agendamento)
            ->assertSee($this->agendamento->data);
    }

    /** @test */
    public function admin_pode_atualizar_agendamento()
    {
        $this->actingAs($this->admin);
        
        $newDate = now()->addDays(2)->format('Y-m-d');

        $response = $this->put("/admin/atualizar/{$this->agendamento->id}", [
            'data' => $newDate,
            'status' => 'confirmado'
        ]);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('agendamentos', [
            'id' => $this->agendamento->id,
            'data' => $newDate,
            'status' => 'confirmado'
        ]);
    }

    /** @test */
    public function admin_pode_excluir_agendamento()
    {
        $this->actingAs($this->admin);
        
        $response = $this->delete("/admin/excluir/{$this->agendamento->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('agendamentos', ['id' => $this->agendamento->id]);
    }

    /** @test */
    public function usuario_comum_nao_pode_acessar_rotas_do_admin()
    {
        $this->actingAs($this->regularUser);
        
        $this->get('/admin')->assertForbidden();
        $this->post("/admin/confirmar/{$this->agendamento->id}")->assertForbidden();
        $this->get("/admin/editar/{$this->agendamento->id}")->assertForbidden();
        $this->put("/admin/atualizar/{$this->agendamento->id}")->assertForbidden();
        $this->delete("/admin/excluir/{$this->agendamento->id}")->assertForbidden();
    }

    /** @test */
    public function visitante_sem_login_nao_pode_acessar_rotas_do_admin()
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->post("/admin/confirmar/{$this->agendamento->id}")->assertRedirect('/login');
        $this->get("/admin/editar/{$this->agendamento->id}")->assertRedirect('/login');
    }
}