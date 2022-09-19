<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
use App\Models\CourseProfessors;

class AuthController extends Controller
{
    private $courseprofessors;
    private $profiles;
    private $professors;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
        $this->courseprofessors = new CourseProfessors();
        $this->profiles         = new Profile();
        $this->professors       = new User();
    }

    /**
     * Attempt to authenticate the user and retrieve a JWT.
     * Note: The API is stateless. This method _only_ returns a JWT. There is not an
     * indicator that a user is logged in otherwise (no sessions).
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        /*// Are the proper fields present?
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            // Login has failed
            return response()->json([
                'data' => [
                    'message' => 'Unauthorized'
                ]
            ], 401);
        }
        return $this->respondWithToken($token);*/

        // Are the proper fields present?
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (!$this->professors->hasProfile($request->input('username'))) {
            // User has no profile
            return response()->json([
                'data' => [
                    'message' => 'Unauthorized'
                ]
            ], 401);
        } elseif (!$token = Auth::attempt($credentials)) {
            // Login has failed
            return response()->json([
                'data' => [
                    'message' => 'Unauthorized'
                ]
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token). Requires a login to use as the
     * JWT in the Authorization header is what is invalidated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'data' => [
                'message' => 'User successfully logged out'
            ]
        ]);
    }

    /**
     * Refresh the current token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
        // return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get logged in user info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $professor = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $courses = $this->courseprofessors->coursesProfessor($professor);
        return response()->json([
            'data' => [
                'user' => [
                    'id'        => Auth::user()->id,
                    'username'  => Auth::user()->username,
                    'firstname' => Auth::user()->firstname,
                    'lastname'  => Auth::user()->lastname,
                    'email'     => Auth::user()->email,
                    'profile'   => [
                        'id'          => Auth::user()->profile->id,
                        'campus'      => Auth::user()->profile->campus,
                        'role'        => Auth::user()->profile->role,
                    ],
                    'courses' => [
                        'total' => count($courses),
                        'list'  => $courses
                    ]
                ]
            ]
        ]);
    }

    public function profiles()
    {
        $profiles = $this->profiles->getProfiles();

        return response()->json([
            'data' => [
                'total'    => count($profiles),
                'profiles' => $profiles
            ]
        ]);
    }

    /**
     * Create a new profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function newProfile(Request $request)
    {
        // if (Gate::denies('create-profile')) {
        //     abort(403, 'No eres administrador');
        // }

        // Are the proper fields present?
        $this->validate($request, [
            'id'     => 'required|integer',
            'campus' => 'required|string|max:9',
            'role'   => 'required|string|max:15',
        ]);

        try {
            $profile = new Profile;
            $profile->mdl_user_id = $request->input('id');
            $profile->campus      = $request->input('campus');
            $profile->role        = $request->input('role');
            $profile->save();

            return response()->json([
                "data" => [
                    'message' => 'Created',
                    'profile' => $profile
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

    /**
     * Delete a profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProfile(Request $request)
    {
        // Are the proper fields present?
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        try {
            $profile = Profile::find($request->input('id'));
            $profile->delete();

            return response()->json([
                "data" => [
                    'message' => 'Deleted',
                    'profile' => $profile
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "data" => [
                    'message' => $e
                ]
            ], 409);
        }
    }

    /**
     * Get all professors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function professors()
    {
        $professorsList = $this->professors->getProfessors();

        return response()->json([
            "data" => [
                'total'      => count($professorsList),
                'professors' => $professorsList
            ]
        ]);
    }

    /**
     * Helper function to format the response with the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            "data" => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ]
        ], 200);
    }
}
