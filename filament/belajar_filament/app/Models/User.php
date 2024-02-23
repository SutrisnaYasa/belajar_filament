<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Team;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// untuk pakai multi tenants
// class User extends Authenticatable implements HasTenants

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'models_has_roles', 'model_id', 'role_id');
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }
    
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
 
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams->contains($tenant);
    }

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        if($panel->getId() === 'admin' && $roles->contains('admin') || $roles->contains('teacher')){
            return true;
        }
        else if($panel->getId() === 'student' && $roles->contains('student')){
            return true;
        }
        else {
            return false;
        }
    }
}
