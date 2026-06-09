<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status',
        'nik',
        'nik_hash',
        'photo',
        'jorong',
        'posyandu_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->nik) {
                $model->nik_hash = hash('sha256', $model->nik);
            }
        });
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is operator
     */
    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    /**
     * Check if user is warga
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    /**
     * Check if user is kepala jorong
     */
    public function isKajor(): bool
    {
        return $this->role === 'kajor';
    }

    /**
     * Check if user is petugas
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Check if user is kader
     */
    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    /**
     * Relasi ke posyandu
     */
    public function posyandu()
    {
        return $this->belongsTo(\App\Models\Posyandu::class);
    }

    /**
     * Relasi ke data penduduk berdasarkan NIK
     */
    public function penduduk()
    {
        return $this->belongsTo(\App\Models\Penduduk::class, 'nik_hash', 'nik_hash');
    }
}
