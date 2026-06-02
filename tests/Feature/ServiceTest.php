<?php

use App\Models\Service;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('profissional pode cadastrar serviço com nome e duração', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
    ]);

    $response = $this->actingAs($professional)->postJson(route('services.store'), [
        'name' => 'Corte de cabelo',
        'duration_minutes' => 30,
    ]);

    $response->assertCreated()
        ->assertJsonPath('service.name', 'Corte de cabelo')
        ->assertJsonPath('service.duration', '30 min');

    $this->assertDatabaseHas('services', [
        'user_id' => $professional->id,
        'name' => 'Corte de cabelo',
        'duration_minutes' => 30,
    ]);
});

test('não permite salvar serviço sem duração', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
    ]);

    $response = $this->actingAs($professional)->postJson(route('services.store'), [
        'name' => 'Barba',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['duration_minutes']);

    expect(Service::count())->toBe(0);
});

test('serviço cadastrado aparece na lista do profissional', function () {
    $professional = User::factory()->create([
        'account_type' => 'profissional',
    ]);

    Service::factory()->create([
        'user_id' => $professional->id,
        'name' => 'Manicure',
        'duration_minutes' => 45,
    ]);

    $this->actingAs($professional)
        ->get(route('services.index'))
        ->assertOk()
        ->assertSee('Manicure')
        ->assertSee('45 min');
});

test('cliente não pode cadastrar serviço', function () {
    $client = User::factory()->create([
        'account_type' => 'cliente',
    ]);

    $this->actingAs($client)
        ->postJson(route('services.store'), [
            'name' => 'Corte',
            'duration_minutes' => 30,
        ])
        ->assertForbidden();
});
