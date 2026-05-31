@props([
    'pending' => 0,
    'confirmed' => 0,
    'completed' => 0,
])

@php
    $maxValue = max($pending, $confirmed, $completed, 1);
    $bars = [
        ['label' => 'Pendentes', 'value' => $pending, 'color' => 'bg-amber-400', 'track' => 'bg-amber-100'],
        ['label' => 'Confirmados', 'value' => $confirmed, 'color' => 'bg-emerald-400', 'track' => 'bg-emerald-100'],
        ['label' => 'Concluídos', 'value' => $completed, 'color' => 'bg-purple-400', 'track' => 'bg-purple-100'],
    ];
@endphp

<x-ui.panel {{ $attributes }}>
    <x-ui.panel-header>Estatísticas de Agendamentos</x-ui.panel-header>

    <div class="grid grid-cols-[auto_1fr] gap-x-3">
        <div class="flex h-28 flex-col justify-between py-1 text-right">
            @for ($i = 4; $i >= 0; $i--)
                <span class="text-[11px] leading-none text-muted">{{ $i }}</span>
            @endfor
        </div>

        <div class="relative flex h-28 flex-col justify-between border-b border-l border-border/60 py-1 pl-3">
            @for ($i = 0; $i < 5; $i++)
                <div class="border-t border-dashed border-border/70"></div>
            @endfor

            <div class="absolute inset-0 flex items-end justify-around gap-3 pl-3 pr-1">
                @foreach ($bars as $bar)
                    @php
                        $height = $bar['value'] > 0
                            ? max(($bar['value'] / $maxValue) * 100, 8)
                            : 4;
                    @endphp

                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <div class="flex w-full max-w-9 flex-1 items-end justify-center">
                            <div
                                class="w-full rounded-t-md {{ $bar['value'] > 0 ? $bar['color'] : $bar['track'] }}"
                                style="height: {{ $height }}%"
                            ></div>
                        </div>
                        <span class="text-[11px] font-medium leading-tight text-muted">{{ $bar['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-ui.panel>
