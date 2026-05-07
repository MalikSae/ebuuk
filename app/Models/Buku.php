<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'judul', 'slug', 'cover', 'file_pdf', 'penulis',
        'deskripsi', 'kategori_id', 'halaman',
    ];

    protected $casts = [
        'halaman' => 'integer',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke RakBuku
    public function rakBuku()
    {
        return $this->hasMany(RakBuku::class);
    }

    // Relasi ke RiwayatBaca
    public function riwayatBaca()
    {
        return $this->hasMany(RiwayatBaca::class);
    }

    // Accessor untuk URL cover
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover && file_exists(public_path('images/covers/' . $this->cover))) {
            return asset('images/covers/' . $this->cover);
        }
        return asset('images/cover-default.svg');
    }

    // Generate slug unik otomatis
    public static function generateSlug(string $judul, ?int $excludeId = null): string
    {
        $slug = Str::slug($judul);
        $original = $slug;
        $counter = 1;
        while (static::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    // Route model binding menggunakan slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
