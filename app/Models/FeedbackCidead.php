<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCidead extends Model
{
    protected $table = 'mdlbol_feedback_cidead';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mdl_grade_grades_id',
        'mdl_user_id',
        'trimester',
        'campus',
        'group',
        'mdl_course_id',
        'feedback_cidead'
    ];

    public function getFeedbackCidead($trimester, $group, $courseId)
    {
        $retVal = FeedbackCidead::where('trimester', $trimester)
            ->where('group', $group)
            ->where('mdl_course_id', $courseId)
            ->get(['id', 'mdl_grade_grades_id', 'mdl_user_id', 'feedback_cidead']);

        return $retVal;
    }

    public function updateFeedbackCidead($id, $feedbackUpdated)
    {
        $retVal = FeedbackCidead::where('id', $id)
            ->update(['feedback_cidead' => $feedbackUpdated]);

        return $retVal;
    }

    public function deleteFeedbackCidead($id)
    {
        $retVal = FeedbackCidead::where('id', $id)
            ->delete();

        return $retVal;
    }
}
