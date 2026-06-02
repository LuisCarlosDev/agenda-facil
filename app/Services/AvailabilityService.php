<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AvailabilityService
{
    /** @return array<int, array{time: string, label: string, starts_at: string}> */
    public function slots(User $professional, Service $service, Carbon $date): array
    {
        return $this->slotsForDuration($professional, $service->duration_minutes, $date);
    }

    /** @return array<int, array{time: string, label: string, starts_at: string}> */
    public function slotsForDuration(User $professional, int $durationMinutes, Carbon $date): array
    {
        $schedule = WorkSchedule::query()
            ->where('user_id', $professional->id)
            ->where('day_of_week', $date->dayOfWeek)
            ->first();

        if (! $schedule) {
            return [];
        }

        return $this->buildSlots(
            $professional,
            $durationMinutes,
            $date,
            $this->normalizeTime($schedule->start_time),
            $this->normalizeTime($schedule->end_time)
        );
    }

    /** @return array<int, array{time: string, label: string, starts_at: string}> */
    public function slotsForWindow(
        User $professional,
        int $durationMinutes,
        Carbon $date,
        string $startTime,
        string $endTime
    ): array {
        return $this->buildSlots($professional, $durationMinutes, $date, $startTime, $endTime);
    }

    /** @return array<int, array{time: string, label: string, starts_at: string}> */
    private function buildSlots(
        User $professional,
        int $durationMinutes,
        Carbon $date,
        string $startTime,
        string $endTime
    ): array {
        if ($date->copy()->startOfDay()->lt(now()->startOfDay())) {
            return [];
        }

        $dayStart = $date->copy()->setTimeFromTimeString($startTime);
        $dayEnd = $date->copy()->setTimeFromTimeString($endTime);

        if ($dayEnd->lte($dayStart)) {
            return [];
        }

        $appointments = $this->appointmentsForDate($professional, $date);

        $slots = [];
        $cursor = $dayStart->copy();

        while ($cursor->copy()->addMinutes($durationMinutes)->lte($dayEnd)) {
            $slotStart = $cursor->copy();
            $slotEnd = $cursor->copy()->addMinutes($durationMinutes);

            if ($date->isToday() && $slotStart->lt(now())) {
                $cursor->addMinutes($durationMinutes);

                continue;
            }

            if (! $this->overlapsAppointments($slotStart, $slotEnd, $appointments)) {
                $slots[] = [
                    'time' => $slotStart->format('H:i'),
                    'label' => $slotStart->format('H:i'),
                    'starts_at' => $slotStart->toIso8601String(),
                ];
            }

            $cursor->addMinutes($durationMinutes);
        }

        return $slots;
    }

    /** @return array<int, string> */
    public function selectableDates(User $professional, int $year, int $month): array
    {
        $activeDays = WorkSchedule::query()
            ->where('user_id', $professional->id)
            ->pluck('day_of_week')
            ->all();

        if ($activeDays === []) {
            return [];
        }

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = $start->copy()->endOfMonth();
        $today = now()->startOfDay();
        $dates = [];

        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            if ($day->lt($today)) {
                continue;
            }

            if (in_array($day->dayOfWeek, $activeDays, true)) {
                $dates[] = $day->format('Y-m-d');
            }
        }

        return $dates;
    }

    public function minimumSlotDuration(User $professional): int
    {
        $min = $professional->services()->min('duration_minutes');

        return $min ? (int) $min : 30;
    }

    public function slotFits(User $professional, Service $service, Carbon $startsAt): bool
    {
        $slots = $this->slots($professional, $service, $startsAt->copy()->startOfDay());

        return collect($slots)->contains(fn (array $slot) => $slot['time'] === $startsAt->format('H:i'));
    }

    /** @return Collection<int, Appointment> */
    private function appointmentsForDate(User $professional, Carbon $date): Collection
    {
        return Appointment::query()
            ->where('professional_id', $professional->id)
            ->whereDate('starts_at', $date)
            ->where('status', '!=', 'cancelled')
            ->get(['starts_at', 'ends_at']);
    }

    /** @param Collection<int, Appointment> $appointments */
    private function overlapsAppointments(Carbon $slotStart, Carbon $slotEnd, Collection $appointments): bool
    {
        return $appointments->contains(
            fn (Appointment $appointment) => $slotStart->lt($appointment->ends_at)
                && $slotEnd->gt($appointment->starts_at)
        );
    }

    private function normalizeTime(string $time): string
    {
        return strlen($time) === 5 ? $time : substr($time, 0, 5);
    }
}
