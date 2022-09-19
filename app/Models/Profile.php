<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'mdlbol_user_profile';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mdl_user_id', 'campus', 'role'
    ];

    public function getProfiles()
    {
        $proflies = Profile::with('user')
            ->orderByDesc('role')
            ->get();

        return $proflies;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'mdl_user_id');
    }
}
