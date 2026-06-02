<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $appointments = $user->isProfissional()
            ? $user->appointmentsAsProfessional()->with(['client', 'service'])->latest('starts_at')->get()
            : $user->appointmentsAsClient()->with(['professional', 'service'])->latest('starts_at')->get();

        $professionals = $user->isCliente()
            ? User::query()
                ->where('account_type', 'profissional')
                ->whereHas('services')
                ->with(['services' => fn ($query) => $query->orderBy('name')])
                ->orderBy('name')
                ->get()
            : collect();

        $professionalServices = $professionals->mapWithKeys(
            fn (User $professional) => [
                (string) $professional->id => $professional->services->map(
                    fn (Service $service) => [
                        'id' => $service->id,
                        'name' => $service->name,
                        'label' => $service->name.' ('.$service->formattedDuration().')',
                    ]
                )->values()->all(),
            ]
        )->all();

        return view('appointments.index', [
            'appointments' => $appointments,
            'professionals' => $professionals,
            'professionalServices' => $professionalServices,
        ]);
    }

    public function store(Request $request, AvailabilityService $availability): RedirectResponse|JsonResponse
    {
        abort_unless(auth()->user()->isCliente(), 403);

        $validated = $request->validate([
            'professional_id' => ['required', 'exists:users,id'],
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
        ]);

        $professional = User::query()
            ->where('id', $validated['professional_id'])
            ->where('account_type', 'profissional')
            ->firstOrFail();

        $service = Service::query()
            ->where('id', $validated['service_id'])
            ->where('user_id', $professional->id)
            ->firstOrFail();

        $startsAt = Carbon::parse($validated['date'].' '.$validated['time']);

        if ($startsAt->lt(now())) {
            return $this->bookingError($request, 'Este horário já passou.');
        }

        if (! $availability->slotFits($professional, $service, $startsAt)) {
            return $this->bookingError($request, 'Este horário não está mais disponível.');
        }

        $appointment = Appointment::create([
            'professional_id' => $professional->id,
            'client_id' => auth()->id(),
            'service_id' => $service->id,
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addMinutes($service->duration_minutes),
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Agendamento realizado com sucesso!',
                'appointment' => [
                    'id' => $appointment->id,
                    'date' => $startsAt->format('d/m/Y'),
                    'time' => $startsAt->format('H:i'),
                    'service' => $service->name,
                    'professional' => $professional->name,
                ],
            ], 201);
        }

        return redirect()->route('appointments.index')->with('toast', [
            'type' => 'success',
            'message' => 'Agendamento realizado com sucesso!',
        ]);
    }

    private function bookingError(Request $request, string $message): RedirectResponse|JsonResponse
    {
        if ($request->wantsJson()) {
            return response()->json(['message' => $message], 422);
        }

        return back()->withErrors(['booking' => $message]);
    }
}
