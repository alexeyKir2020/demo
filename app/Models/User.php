<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\UsesApproves;
use App\Models\Traits\UsesBans;
use App\Models\Traits\UsesDeletes;
use App\Models\Traits\UsesMarkdown;
use App\Models\Traits\UsesRestores;
use App\Models\Traits\UsesSeo;
use App\Models\Traits\UsesSlugs;
use App\Models\Traits\UsesStatuses;
use App\Models\Traits\UsesUpdates;
use App\Models\Traits\UsesUUID;
//use App\Notifications\MailResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Meta\Status;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Notifications\VerifyEmailQueuedNotification;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,
        HasRoles,
        Notifiable,
        HasApiTokens,
        Notifiable,
        UsesUUID,
        SoftDeletes,
        UsesStatuses,
        UsesApproves,
        UsesUpdates,
        UsesBans,
        UsesRestores,
        UsesDeletes,
        UsesSeo,
        UsesMarkdown,
        UsesSlugs;

    protected $table = 'users';
    const ENTITY = 'User';
    const SlUG = 'users';

    public $timestamps = true;
    public $incrementing = false;

    protected $observables = [
        'created',
        'verified',
        'updated',
        'saved',
        'deleted',
        'restored',
        'rolesAssigned',
        'hardDeleted',
        'suspended',
        'published',
    ];

    /*
     * Validation rules
     */

    public const CREATE_RULES = array(
        'first_name' => 'string|min:2|max:100',
        'last_name' => 'string|min:2|max:100',
        'middle_name' => 'string|min:2|max:100',
        'avatar' => 'string|min:2|max:100',
        'email' => 'required|string|min:3|max:255|email|unique:App\Models\User,email',
        'phone' => 'string|min:5|max:20',
        'password' => 'required|string|min:6|max:100|confirmed',
        'subscribed' => 'boolean'
    );

    public const UPDATE_RULES = array(
        'first_name' => 'string|min:2|max:100',
        'last_name' => 'string|min:2|max:100',
        'middle_name' => 'string|min:2|max:100',
        'avatar' => 'string|min:2|max:100',
        'email' => 'string|min:3|max:255|email|unique:App\Models\User,email',
        'phone' => 'string|min:5|max:20',
        'password' => 'string|min:6|max:100|confirmed',
        'subscribed' => 'boolean'
    );

    public const GRANTED_RULES = array(
        'status' => 'integer|nullable',
        'identity_verified_at' => '',
        'roles' => 'array',
    );

    protected $fillable = [
        'email',
        'phone',
        'password',
        'first_name',
        'last_name',
        'middle_name',
        'avatar',
        'subscribed'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'identity_verified_at' => 'datetime',
    ];

    const READABLE = [
        'id',
        'first_name',
        'last_name',
        'middle_name',
        'avatar',
        'email',
        'phone',
        'status',
        'created_at',
        'roles.id',
        'roles.name'
    ];

    const SORTABLE = [
        'id',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'status',
        'created_at',
        'roles.id',
        'roles.name'
    ];


    public static function queryByRequest($request = null)
    {
        $query = QueryBuilder::for(self::class, $request)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('email'),
                AllowedFilter::exact('phone'),
                AllowedFilter::exact('created_at'),
                AllowedFilter::exact('status'),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(self::SORTABLE)
            ->allowedFields(self::READABLE)
            ->allowedIncludes(['roles']);

        $count = $request->query('per-page', false);

        if($count) {
            return $query->paginate($count);
        }

        return $query->get();
    }



    public function getRoles(): Collection
    {
        return $this->roles->pluck('id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public static function create ($attributes = ['*']) {
        $instance = new self($attributes);

        $instance->email = $attributes['email'];
        $instance->password = $attributes['password'];
        $instance->status = Status::CREATED;
        $instance->identity_verified_at = $attributes['identity_verified_at'] ?? null;

        if($instance->save()) {
            $instance->roles = $attributes['roles'] ?? null;
            return $instance;
        }
        else
            return false;
    }

    public function update(array $attributes = [], array $options  = []) {

        if(parent::update($attributes, $options)) {
            $this->roles = $attributes['roles'] ?? null;
            return true;
        }

        return false;
    }

    public function verifyEmail()
    {
        $this->status = Status::PUBLISHED;
        $this->role = $this->assignRole('guest', 'user');
        $this->identity_verified_at = Carbon::now();

        if(parent::save()) {
            $this->fireModelEvent('verifiedEmail', false);

            return true;
        }

        return false;
    }

    public function isIdentityVerified()
    {
        return (bool)$this->identity_verified_at;
    }

    /*
    * Mutators
    */

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setSubscribedAttribute($value)
    {
        $this->attributes['subscribed'] = $value ? $value : false;
    }

    public function setIdentityVerifiedAtAttribute($value)
    {
        if($value) {
            $this->attributes['identity_verified_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
            $this->status = Status::PUBLISHED;
        }
    }

    public function setPasswordAttribute(string $password)
    {
        if (Hash::needsRehash($password)) {
            $password = Hash::make($password);
        }

        $this->attributes['password'] = $password;
    }

    public function setRolesAttribute($roles = ['guest'])
    {
        if($roles) {
            foreach ($roles as $role)
                $this->assignRole($role['name']);

            $this->fireModelEvent('rolesAssigned', false);
        }
    }



    /*
     * Relations
     */

    public function organisations()
    {
        return $this->belongsToMany(
            Organisation::class,
            'organisations_users',
            'user_id',
            'organisation_id')
            ->withPivot('is_owner');
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function authProviders()
    {
        return $this->hasMany(AuthProvider::class, 'user_id', 'id');
    }

    /*
     * Meta info
     * @return array
     */
    public static function getMetaData() {
        return [
            'relations' => [
                'roles' => Role::all(),
            ]
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueuedNotification());
    }
}
