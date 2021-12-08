<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use App\Models\Profile;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'mdl_user';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'auth',
        'policyagreed',
        'password',
        'mnethostid',
        'idnumber',
        'emailstop',
        'icq',
        'skype',
        'yahoo',
        'aim',
        'msn',
        'phone1',
        'phone2',
        'institution',
        'department',
        'address',
        'city',
        'country',
        'lang',
        'calendartype',
        'theme',
        'timezone',
        'firstaccess',
        'lastaccess',
        'lastlogin',
        'currentlogin',
        'lastip',
        'secret',
        'picture',
        'url',
        'description',
        'descriptionformat',
        'mailformat',
        'maildigest',
        'maildisplay',
        'autosubscribe',
        'trackforums',
        'timecreated',
        'timemodified',
        'trustbitmask',
        'imagealt',
        'lastnamephonetic',
        'firstnamephonetic',
        'middlename',
        'alternatename',
        'moodlenetprofile'
    ];

    /**
     * Retrieve the identifier for the JWT key.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getProfessors()
    {
        /*$professors = User::where('confirmed', 1)
            ->where('deleted', 0)
            ->where('suspended', 0)
            ->where('email', 'like', '%@ceehabana.com')
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname']);
        */
        $profiles = Profile::all(['mdl_user_id'])->toArray();

        $professors = User::select("id", DB::raw("CONCAT(firstname,' ',lastname) AS fullname"))
            ->where('confirmed', 1)
            ->where('deleted', 0)
            ->where('suspended', 0)
            ->where('email', 'like', '%@ceehabana.com')
            ->whereNotIn('id', $profiles)
            ->orderBy('fullname')
            ->get();

        return $professors;
    }

    public function userName($id)
    {
        $student = User::where('id', $id)
            ->get(['id', 'firstname', 'lastname']);

        return $student;
    }

    public function hasProfile($username)
    {
        $profile = User::with('profile')
            ->where('username', $username)
            ->first();

        if ($profile) {
            return $profile->profile;
        } else {
            return false;
        }
    }

    public function getProfiles()
    {
        $proflies = User::with('profile.user')
            ->get();

        return $proflies;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'mdl_user_id');
    }
}
