<?php

namespace App\Models;

use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use App\Models\Meta\Status;
use App\Models\Traits\UsesApproves;
use App\Models\Traits\UsesBans;
use App\Models\Traits\UsesDeletes;
use App\Models\Traits\UsesMarkdown;
use App\Models\Traits\UsesRestores;
use App\Models\Traits\UsesSeo;
use App\Models\Traits\UsesSlugs;
use App\Models\Traits\UsesStatuses;
use App\Models\Traits\UsesUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class Organisation extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        UsesStatuses,
        UsesApproves,
        UsesUpdates,
        UsesBans,
        UsesRestores,
        UsesDeletes,
        UsesSeo,
        UsesMarkdown,
        UsesSlugs,
        InteractsWithMedia;

    protected $table = 'organisations';
    const ENTITY = 'Organisation';
    const SlUG = 'organisations';

    public $timestamps = true;

    protected $observables = [
        'banned',
        'unbanned',
        'approved',
        'removed',
        'deleted',
        'updated',
        'created'
    ];

    protected $fillable = [
        'title',
        'link',
        'email',
        'phone',
        'city_id',
        'city',
        'type_id',
        'type',
        'avatar',
        'reg_number',
        'contact_person',
        'addition_phone',
        'addition_email',
    ];

    protected $hidden = [
    ];

    public const CREATE_RULES = array(
        'title' => 'required|string|min:3|max:255',
        'link' => 'string|min:3|max:255',
        'email' => 'required|string|min:3|max:255|email',
        'phone' => 'required|string|min:3|max:255',
        'city_id' => 'integer',
        'type_id' => 'required|integer',
        'avatar' => 'string',
        'reg_number' => 'required|digits:9',
        'contact_person' => 'required|string|min:3|max:100',
        'additional_email' => 'string|min:3|max:255|email',
        'additional_phone' => 'string|min:3|max:255',
    );

    public const UPDATE_RULES = array(
        'title' => 'string|min:3|max:255',
        'link' => 'string|min:3|max:255',
        'email' => 'string|min:3|max:255|email',
        'phone' => 'string|min:3|max:255',
        'city_id' => 'integer',
        'type_id' => 'integer',
        'avatar' => 'string',
        'reg_number' => 'digits:9',
        'contact_person' => 'string|min:3|max:100',
        'additional_email' => 'string|min:3|max:255|email',
        'additional_phone' => 'string|min:3|max:255',
    );

    public const GRANTED_RULES = array(
        'status' => 'integer|nullable',
    );

    const READABLE = [
        'id',
        'phone',
        'status',
        'created_at',
        'users.id',
    ];

    const SORTABLE = [
        'id',
        'phone',
        'status',
        'created_at',
        'users.id',
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
            ->allowedIncludes(['users']);

        $count = $request->query('per-page', false);

        if($count) {
            return $query->paginate($count);
        }

        return $query->get();
    }

    public static function create($attributes = ['*']) {
        $instance = new self($attributes);
        $instance->status = Status::CREATED;

        if($instance->save()) {
            $instance->roles = ['id' => Auth::user()->id, 'is_owner' => true];
            return $instance;
        }
        else
            return false;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type_id'] = $value['id'];
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city_id'] = $value['id'];
    }

    public function type()
    {
        return $this->belongsTo(OrganisationType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function update(array $attributes = [], array $options  = []) {

        if(parent::update($attributes, $options)) {
            $this->users = $attributes['users'] ?? null;
            return true;
        }

        return false;
    }

    public function setUsersAttribute($users)
    {
        if($users) {
            foreach ($users as $user)
                $this->users()->attach($user['id'], ['is_owner' => $user->$user['is_owner']]);
            $this->fireModelEvent('userAttached', false);
        }
    }

    public function users()
    {
        return $this
            ->belongsToMany(
            User::class,
            'organisations_users',
            'organisation_id',
            'user_id'
        )->withPivot('is_owner');
    }

    public static function getMetaData() {
        return  [
            'relations' => [
                'cities' => City::all(),
                'organisation_types' => OrganisationType::all(),
            ],
        ];
    }
}
