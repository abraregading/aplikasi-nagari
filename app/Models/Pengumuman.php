<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'isi',
        'tipe',
        'target_user_id',
        'created_by',
        'is_active',
        'published_at',
    ];

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeUntukWarga($query, $userId)
    {
        return $query->aktif()
            ->where(function ($q) use ($userId) {
                $q->where('tipe', 'umum')
                  ->orWhere(function ($sub) use ($userId) {
                      $sub->where('tipe', 'khusus')
                          ->where('target_user_id', $userId);
                  });
            })
            ->latest();
    }
}
