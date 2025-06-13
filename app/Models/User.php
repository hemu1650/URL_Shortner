<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id', // ✅ VERY IMPORTANT
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


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Admin -> Members
    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'company_id')->where('role', 'member');
    }

    // Member/Admin -> Short URLs
    public function shortUrls()
    {
        return $this->hasMany(\App\Models\ShortUrl::class);
    }


    public function companyUsers()
    {
        return $this->hasMany(User::class, 'company_id', 'company_id')
            ->whereIn('role', ['admin', 'member']);
    }




}
