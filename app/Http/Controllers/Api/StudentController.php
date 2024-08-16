<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students=Student::all();
        return StudentResource::collection($students);
    }

    function show($id)
     {
       $student=Student::findOrFail($id);
       return new StudentResource($student);
     }
 
}
