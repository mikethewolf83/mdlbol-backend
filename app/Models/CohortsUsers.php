<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CohortsUsers extends Model
{
    public function studentsInGroup($group)
    {
        $userid = PivotNotes::distinct()->get(['userid']);

        $retVal = CohortsUsers::whereIn('id', $userid)
            ->where('Cohorte', $group)
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname']);

        return $retVal;
    }
}
