<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()->isProfissional(), 403);

        $services = auth()->user()
            ->services()
            ->latest()
            ->get();

        return view('services.index', [
            'services' => $services,
        ]);
    }

    public function options(): JsonResponse
    {
        abort_unless(auth()->user()->isProfissional(), 403);

        $services = auth()->user()
            ->services()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'services' => $services,
        ]);
    }

    public function bookingOptions(Request $request): JsonResponse
    {
        abort_unless(auth()->user()->isCliente(), 403);

        $validated = $request->validate([
            'professional_id' => ['required', 'exists:users,id'],
        ]);

        $professional = User::query()
            ->where('id', $validated['professional_id'])
            ->where('account_type', 'profissional')
            ->firstOrFail();

        $services = $professional->services()
            ->orderBy('name')
            ->get()
            ->map(fn (Service $service) => [
                'id' => $service->id,
                'name' => $service->name,
                'label' => $service->name.' ('.$service->formattedDuration().')',
            ])
            ->values();

        return response()->json([
            'services' => $services,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        abort_unless(auth()->user()->isProfissional(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ], [
            'duration_minutes.required' => 'Informe a duração do serviço.',
            'duration_minutes.min' => 'A duração deve ser de pelo menos 1 minuto.',
        ]);

        $service = Service::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'duration_minutes' => $validated['duration_minutes'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
        ]);

        return response()->json([
            'message' => 'Serviço cadastrado com sucesso!',
            'service' => $service->toListArray(),
        ], 201);
    }
}
