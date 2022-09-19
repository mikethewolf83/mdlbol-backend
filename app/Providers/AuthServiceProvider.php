<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\CourseProfessors;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Only Admins can create profiles
        Gate::define('admin', function ($user) {
            return $user->profile->role == 'Admin';
        });

        /**
         * CIDEAD Authorizations
         */

        // Only Supervisors, Managers and Admins can accesss
        Gate::define('cidead', function ($user) {
            return ($user->profile->role == 'Supervisor EP' || $user->profile->role == 'Supervisor ESO' || $user->profile->role == 'Supervisor BACH' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        /**
         * EP Authorizations
         */

        // Only 1EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('1ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('1 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 2EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('2ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('2 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 3EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('3ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('3 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 4EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('4ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('4 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 5EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('5ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('5 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 6EP professors, Supervisors EP, Managers and Admins can access
        Gate::define('6ep', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('6 EP', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor EP' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        /**
         * ESO Authorizations
         */

        // Only 1ESO professors, Supervisors ESO, Managers and Admins can access
        Gate::define('1eso', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('1 ESO', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor ESO' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 2ESO professors, Supervisors ESO, Managers and Admins can access
        Gate::define('2eso', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('2 ESO', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor ESO' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 3ESO professors, Supervisors ESO, Managers and Admins can access
        Gate::define('3eso', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('3 ESO', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor ESO' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 4ESO professors, Supervisors ESO, Managers and Admins can access
        Gate::define('4eso', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('4 ESO', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor ESO' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        /**
         * BACH Authorizations
         */

        // Only 1BACH professors, Supervisors ESO, Managers and Admins can access
        Gate::define('1bach', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('1 BACH', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor BACH' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });

        // Only 2BACH professors, Supervisors ESO, Managers and Admins can access
        Gate::define('2bach', function ($user) {
            $professor = $user->firstname . ' ' . $user->lastname;
            $cursoprofesores = new CourseProfessors();
            $catcurso = $cursoprofesores->coursesProfessor($professor);
            return (in_array('2 ESO', array_merge(...$catcurso)) || $user->profile->role == 'Supervisor BACH' || $user->profile->role == 'Manager' || $user->profile->role == 'Admin');
        });
    }
}
