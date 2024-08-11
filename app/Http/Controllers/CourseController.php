<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $students=Course::all();
        return view('courses.coursesData',compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    function store( Request $request)
    {

       $request->validate([
           'name' => 'required',
           'address' => 'required',
           'email' => 'required|email',
           'gender' => 'required',
           'image' => 'required|image',
           'grade' => 'required',
       ]);
      $img = $request->file('image');
      $ext = $img->getClientOriginalExtension();
      $name = uniqid() . '.' . $ext;
      $img->move(public_path('uploads/students'), $name);


      Student::create([
       'name' => $request->name,
       'email' => $request->email,
       'address' => $request->address,
       'gender' => $request->gender,
       'image' => $name,
       'grade' => $request->grade,
      ]);

      
      return to_route('students.index');

      
     


    }
   

    /**
     * Display the specified resource.
     */

    
     function view($id)
     {
       $student=Student::findOrFail($id);
       return view('students.studentData',compact("student"));
     }
 
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student=Student::findOrFail($id);
        return view('students.update',compact("student"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'image' => 'nullable|image',
            'grade' => 'required',
        ]);
    
        $student = Student::findOrFail($id);
    
       
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = uniqid() . '.' . $ext;
            $img->move(public_path('uploads/students'), $name);
            $student->image = $name;
        }
    
       
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'grade' => $request->grade,
        ]);
    
       
        $student->save();
    
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student=Student::findOrFail($id);
         $student->delete();
         return to_route('students.index');
    }
}
