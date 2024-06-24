<?php

namespace App\Models;

use App\Traits\HasPermissions;
use App\Traits\HasProfilePhoto;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use HasPermissions;
    use HasApiTokens;
    use Notifiable;
    use HasProfilePhoto;
    use HasUuid;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'deposit',
        'role_id',
        'birthday',
        'gender',
        'contact_email',
        'contact_phone',
        'contact_phone_dial_code',
        'contact_phone_iso2',
        'area_id',
        'address',
        'notes',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role_id', Role::ADMIN)->orWhere('role_id', Role::SUPER_ADMIN);
    }
    /**
     * Scope a query to search users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class)->withTrashed();
    }

    /**
     * Check if user is super admin.
     *
     * @return bool
     */
    public function getIsSuperAdminAttribute(): bool
    {
        return $this->role_id == Role::SUPER_ADMIN;
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->role_id == Role::ADMIN || $this->role_id == Role::SUPER_ADMIN;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name, 2)[0];
    }

    public function getJoinedAtAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getIsSuperDealerAttribute(): bool
    {
        return  $this->deposit > 0;
    }

    public function getRoleAttribute(): string
    {
        return  Role::$roleTexts[$this->role_id];
    }

    public function getIsMaleAttribute(): bool
    {
        return $this->gender == "male";
    }
    public function getIsFemaleAttribute(): bool
    {
        return $this->gender == "female";
    }

    public function getBirthdayDateAttribute()
    {
        if (is_null($this->birthday)) return null;
        return Carbon::parse($this->birthday)->format(config('app.default_date_format_full'));
    }

    public function getFullPhoneAttribute(): string|null
    {
        if (is_null($this->phone)) return null;
        return "+{$this->phone_dial_code} {$this->phone}";
    }
    public function getFullContactPhoneAttribute(): string|null
    {
        if (is_null($this->contact_phone)) return null;
        return "+{$this->contact_phone_dial_code} {$this->contact_phone}";
    }
}
