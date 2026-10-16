<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    // ✅ កន្ត្រកទាំងអស់របស់ user (active + checked_out)
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // ✅ កន្ត្រកបច្ចុប្បន្ន (status = active) ប្រើញឹកញាប់បំផុត
    public function activeCart(): HasOne
    {
        return $this->hasOne(Cart::class)->where('status', 'active')->latestOfMany();
    }

    // ✅ ប្រវត្តិបញ្ជាទិញ
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}