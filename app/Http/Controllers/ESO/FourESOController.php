<?php

namespace App\Http\Controllers\EP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseProfessors;
use App\Models\CohortsUsers;
use App\Models\PivotNotes;
use App\Models\FeedbackMoodle;
use App\Models\FeedbackCidead;
use App\Models\User;

class FourESOController extends Controller
{
    private $curseprofessors;
    private $cohortsusers;
    private $pivotnotes;
    private $feedbackmoodle;
    private $feedbackcidead;
    private $user;

    public function __construct()
    {
        $this->curseprofessors = new CourseProfessors();
        $this->cohortsusers    = new CohortsUsers();
        $this->pivotnotes      = new PivotNotes();
        $this->feedbackmoodle  = new FeedbackMoodle();
        $this->feedbackcidead  = new FeedbackCidead();
        $this->user            = new User();
        define('CAMPUS', 'INSTITUTO');
        define('GROUP', '4ESO');
        define('GROUP_SPACED', '4 ESO');
    }

    public function index()
    {
        $courses  = $this->curseprofessors->coursesInGroup(GROUP_SPACED);
        $students = $this->cohortsusers->studentsInGroup(GROUP);

        $retVal = ($courses && $students)
            ? response()->json([
                "data" => [
                    "courses" => [
                        'total' => count($courses),
                        'list'  => $courses
                    ],
                    "students" => [
                        'total' => count($students),
                        'list'  => $students
                    ]
                ]
            ])
            : abort(404, 'Not Found.');

        return $retVal;
    }

    public function group(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'trimester' => 'required|string',
            'course'    => 'required|integer',
        ]);

        $reqTrimester = $request->input('trimester');
        $reqCourse    = $request->input('course');
        $courseName   = $this->curseprofessors->courseName($reqCourse);
        $pivotnotas   = $this->pivotnotes->gradesTrimGroup($reqTrimester, CAMPUS, GROUP, $reqCourse);
        $cidead       = $this->feedbackcidead->getFeedbackCidead($reqTrimester, GROUP, $reqCourse);

        $retVal = ($pivotnotas)
            ? response()->json([
                "data" => [
                    "course"          => $courseName,
                    "grades"          => $pivotnotas,
                    "feedback_cidead" => $cidead
                ]
            ])
            : abort(404, 'Not Found.');

        return $retVal;
    }

    public function students(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'trimester' => 'required|string',
            'student'   => 'required|integer',
        ]);

        $reqTrimester = $request->input('trimester');
        $reqStudent   = $request->input('student');
        $studentName  = $this->user->userName($reqStudent);
        $pivotnotas   = $this->pivotnotes->gradesTrimStudents($reqTrimester, CAMPUS, GROUP, $reqStudent);

        $retVal = ($pivotnotas)
            ? response()->json([
                "data" => [
                    "student" => $studentName,
                    "grades"  => $pivotnotas
                ]
            ])
            : abort(404, 'Not Found.');

        return $retVal;
    }

    public function updateMoodle(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'feedbackid' => 'required|integer',
            'feedback'   => 'required|string',
        ]);

        try {
            $reqFeedbackId = $request->input('feedbackid');
            $reqFeedback   = $request->input('feedback');
            $this->feedbackmoodle->updateFeedbackMoodle($reqFeedbackId, $reqFeedback);

            return response()->json([
                "data" => [
                    'message' => 'Action succeded'
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [
                    'message' => $e
                ]
            ], 409);
        }
    }

    public function newCidead(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'feedback_id'     => 'required|integer',
            'user_id'         => 'required|integer',
            'trimester'       => 'required|string|max:3',
            'campus'          => 'required|string|max:50',
            'group'           => 'required|string|max:20',
            'course_id'       => 'required|integer',
            'feedback_cidead' => 'required|string',
        ]);

        try {
            $reqFeedbackId     = $request->input('feedback_id');
            $reqUserId         = $request->input('user_id');
            $reqTrimester      = $request->input('trimester');
            $reqCampus         = $request->input('campus');
            $reqGroup          = $request->input('group');
            $reqCourseId       = $request->input('course_id');
            $reqFeedbackCidead = $request->input('feedback_cidead');

            $newFeedbackCidead = new FeedbackCidead;
            $newFeedbackCidead->mdl_grade_grades_id = $reqFeedbackId;
            $newFeedbackCidead->mdl_user_id         = $reqUserId;
            $newFeedbackCidead->trimester           = $reqTrimester;
            $newFeedbackCidead->campus              = $reqCampus;
            $newFeedbackCidead->group               = $reqGroup;
            $newFeedbackCidead->mdl_course_id       = $reqCourseId;
            $newFeedbackCidead->feedback_cidead     = $reqFeedbackCidead;
            $newFeedbackCidead->save();

            return response()->json([
                "data" => [
                    'message' => 'Action succeded'
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [
                    'message' => $e
                ]
            ], 409);
        }
    }

    public function updateCidead(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'id'              => 'required|integer',
            'feedback_cidead' => 'required|string',
        ]);

        try {
            $reqId              = $request->input('id');
            $reqFeedbackCidead  = $request->input('feedback_cidead');

            $this->feedbackcidead->updateFeedbackCidead($reqId, $reqFeedbackCidead);

            return response()->json([
                "data" => [
                    'message' => 'Action succeded'
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [
                    'message' => $e
                ]
            ], 409);
        }
    }

    public function deleteCidead(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        try {
            $reqId = $request->input('id');
            $this->feedbackcidead->deleteFeedbackCidead($reqId);

            return response()->json([
                "data" => [
                    'message' => 'Action succeded'
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [
                    'message' => $e
                ]
            ], 409);
        }
    }
}
