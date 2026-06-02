<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'duration_minutes',
        'description',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formattedDuration(): string
    {
        $minutes = $this->duration_minutes;

        if ($minutes < 60) {
            return "{$minutes} min";
        }

        $hours = intdiv($minutes, 60);
        $remaining = $minutes % 60;

        if ($remaining === 0) {
            return "{$hours}h";
        }

        return "{$hours}h {$remaining} min";
    }

    public function formattedPrice(): ?string
    {
        if ($this->price === null) {
            return null;
        }

        return 'R$ '.number_format((float) $this->price, 2, ',', '.');
    }

    public function toListArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->formattedDuration(),
            'price' => $this->formattedPrice(),
        ];
    }
}
