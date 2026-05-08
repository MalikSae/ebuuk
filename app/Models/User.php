<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'gender', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && $this->gender) {
            $folder = $this->gender === 'laki-laki' ? 'man' : 'woman';
            $path = public_path("images/{$folder}/{$this->avatar}.png");
            if (file_exists($path)) {
                return asset("images/{$folder}/{$this->avatar}.png");
            }
        }
        return asset('images/cover-default.svg');
    }

    // Relasi ke rak buku user
    public function rakBuku()
    {
        return $this->hasMany(RakBuku::class);
    }

    // Relasi ke riwayat baca user
    public function riwayatBaca()
    {
        return $this->hasMany(RiwayatBaca::class);
    }
}
