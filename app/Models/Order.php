<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'status', 'created_at', 'updated_at'];

    const PENDIENTE = 1;
    const RECIBIDO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;
    const ANULADO = 5;

    const ESTATUSES = [
        self::PENDIENTE => [
            'label' => 'Pendiente',
            'color' => 'red',
            'icon' => 'fa-business-time',
        ],
        self::RECIBIDO => [
            'label' => 'Recibido',
            'color' => 'gray',
            'icon' => 'fa-business-time',
        ],
        self::ENVIADO => [
            'label' => 'Enviado',
            'color' => 'yellow',
            'icon' => 'fa-truck',
        ],
        self::ENTREGADO => [
            'label' => 'Entregado',
            'color' => 'pink',
            'icon' => 'fa-check-circle',
        ],
        self::ANULADO => [
            'label' => 'Anulado',
            'color' => 'green',
            'icon' => 'fa-times-circle',
        ],
    ];

    // Relación uno a muchos inversa
    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detalle_status($campo) {
        return $this->status != null ? self::ESTATUSES[$this->status][$campo] : '';
    }
}
