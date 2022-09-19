<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackMoodle extends Model
{
    protected $table = 'mdl_grade_grades';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['feedback'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'rawgrade',
        'rawgrademax',
        'rawgrademin',
        'rawscaleid',
        'usermodified',
        'finalgrade',
        'hidden',
        'locked',
        'locktime',
        'exported',
        'overridden',
        'excluded',
        'feedbackformat',
        'information',
        'informationformat',
        'timecreated',
        'timemodified',
        'aggregationstatus',
        'aggregationweight'
    ];

    public function updateFeedbackMoodle($id, $feedbackUpdated)
    {
        $retVal = FeedbackMoodle::where('id', $id)
            ->update(['feedback' => $feedbackUpdated]);

        return $retVal;
    }
}
