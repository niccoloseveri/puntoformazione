<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

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
        'surname',
        'email',
        'via',
        'citta',
        'tel',
        'cap',
        'cf',
        'is_teacher',
        'password',
        'data_nascita',
        'luogo_nascita',
        'paese_nascita',
        'prov_nascita',
        'cittadinanza',
        'titolo_studio',
        'genere',
        'note',
        'prov',
        'paese_residenza',
        'piva',
        'document_uploaded',
        'cf_uploaded',
        'permesso_uploaded',
        'interesse_uploaded',
        'contratto_uploaded',
        'whatsapp_uploaded',
        'roles',
        'courses_id',
        'classrooms'

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

    public function canAccessPanel(Panel $panel): bool
    {
        /*if($panel->getId() === 'admin'){
            return auth()->user()->isAdmin();
        }
            */
        return true;
    }

    public function canImpersonate(){
        return $this->isAdmin();
    }

    /**
     * Get all of the subscriptions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscriptions::class);
    }

    /**
     * The courses that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses() : BelongsToMany {
        return $this->belongsToMany(Courses::class,'subscriptions','user_id')->withPivot('classrooms_id','start_date');
    }

    /**
     * The classrooms that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classrooms::class,'subscriptions','user_id')->withPivot('courses_id','start_date');
    }
    /**
     * Get all of the attendances for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany {
        return $this->hasMany(Attendance::class);
    }

    public function isAdmin() {
        return $this->roles->contains('name', 'admin');
    }
    public function notAdmin() {
        if($this->roles->contains('name', 'admin')){
            return false;
        }else if ($this->roles->contains('name', 'Nazzareno')){
            return false;
        }
        else {
            return true;
        }
    }

    public function isNazza(){
        return $this->roles->contains('name', 'Nazzareno');
    }



}
