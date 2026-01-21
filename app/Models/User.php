<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * العلاقة مع السلة
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * العلاقة مع الطلبات
     */
  

    public function orders()
{
    return $this->hasMany(\App\Models\Order::class);
}
    /**
     * الصفات القابلة للتعيين جماعيًا
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * الصفات المخفية عند التحويل إلى JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * التحويلات (Casting) للحقول
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
