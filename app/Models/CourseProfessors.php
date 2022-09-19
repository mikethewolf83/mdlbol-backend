<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PivotNotes;

class CourseProfessors extends Model
{
    protected $table = 'CursoProfesores';

    public function coursesInGroup($group)
    {
        $courseid = PivotNotes::distinct()->get(['courseid']);

        $retVal = CourseProfessors::whereIn('CursoId', $courseid)
            ->where('CatCurso', $group)
            ->where('Curso', 'not like', 'Tutoría%')
            ->where('Curso', 'not like', 'Orientación%')
            ->where('Curso', 'not like', 'Plan%')
            ->where('Curso', 'not like', 'Música%')
            ->where('Curso', 'not like', 'Plástica%')
            ->orderBy('Curso')
            ->get(['CursoId as course_id', 'Curso as course']);

        return $retVal;
    }

    public function coursesProfessor($professor)
    {
        $retVal = CourseProfessors::where('Profesores', 'like', '%'.$professor.'%')
            ->orderBy('CatCurso')
            ->get(['CatCurso', 'Curso'])
            ->toArray();

        return $retVal;
    }

    public function courseName($id)
    {
        $retVal = CourseProfessors::where('CursoId', $id)
            ->get(['CursoId as id', 'Curso as course_name', 'Profesores as professsors']);

        return $retVal;
    }
}
