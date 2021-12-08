<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PivotNotes extends Model
{
    protected $table = 'PivotNotas';

    public function gradesTrimGroup($trimester, $campus, $group, $course)
    {
        $pivotnotas = DB::table('PivotNotas')
            ->join('COHORTS_USERS', 'PivotNotas.userid', '=', 'COHORTS_USERS.id')
            ->join('CursoProfesores', 'PivotNotas.courseid', '=', 'CursoProfesores.CursoId')
            ->where('trimestre', $trimester)
            ->where('CursoProfesores.ParentCatCurso', $campus)
            ->where('COHORTS_USERS.Cohorte', $group)
            ->where('CursoProfesores.CursoId', $course)
            ->where('CursoProfesores.Curso', 'not like', 'Tutoría%')
            ->where('CursoProfesores.Curso', 'not like', 'Orientación%')
            ->where('CursoProfesores.Curso', 'not like', 'Plan%')
            ->where('CursoProfesores.Curso', 'not like', 'Música%')
            ->where('CursoProfesores.Curso', 'not like', 'Plástica%')
            ->whereNotNull('NotaTrimestre')
            ->get();

        return $pivotnotas;
    }

    public function gradesTrimStudents($trimester, $campus, $group, $student)
    {
        $pivotnotas = DB::table('PivotNotas')
            ->join('COHORTS_USERS', 'PivotNotas.userid', '=', 'COHORTS_USERS.id')
            ->join('CursoProfesores', 'PivotNotas.courseid', '=', 'CursoProfesores.CursoId')
            ->where('Trimestre', $trimester)
            ->where('CursoProfesores.ParentCatCurso', $campus)
            ->where('COHORTS_USERS.Cohorte', $group)
            ->where('COHORTS_USERS.id', $student)
            ->where('CursoProfesores.Curso', 'not like', 'Tutoría%')
            ->where('CursoProfesores.Curso', 'not like', 'Orientación%')
            ->where('CursoProfesores.Curso', 'not like', 'Plan%')
            ->where('CursoProfesores.Curso', 'not like', '%Artística%')
            ->get();


        return $pivotnotas;
    }
}
