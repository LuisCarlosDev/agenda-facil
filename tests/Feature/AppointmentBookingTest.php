<?php

use App\Models\Service;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('cliente vê serviços do profissional no diálogo de agendamento', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
        'name' => 'Ana Profissional',
    ]);

    Service::factory()->create([
        'user_id' => $professional->id,
        'name' => 'Corte de cabelo',
        'duration_minutes' => 30,
    ]);

    $client = User::factory()->create([
        'account_type' => 'cliente',
    ]);

    $this->actingAs($client)
        ->get(route('appointments.index'))
        ->assertOk()
        ->assertSee('Ana Profissional', false)
        ->assertSee('Corte de cabelo', false)
        ->assertSee('data-professional-services', false)
        ->assertSee('data-booking-services-for', false)
        ->assertSee('booking-services-url', false);
});

test('cliente pode listar serviços de um profissional para agendamento', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
    ]);

    Service::factory()->create([
        'user_id' => $professional->id,
        'name' => 'Manicure',
        'duration_minutes' => 45,
    ]);

    $client = User::factory()->create([
        'account_type' => 'cliente',
    ]);

    $this->actingAs($client)
        ->getJson(route('services.booking-options', ['professional_id' => $professional->id]))
        ->assertOk()
        ->assertJsonPath('services.0.name', 'Manicure')
        ->assertJsonPath('services.0.label', 'Manicure (45 min)');
});

test('profissional não acessa opções de agendamento de serviços', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
    ]);

    $this->actingAs($professional)
        ->getJson(route('services.booking-options', ['professional_id' => $professional->id]))
        ->assertForbidden();
});
