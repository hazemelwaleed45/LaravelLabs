<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $couCourses=Course::all();
        return view('courses.coursesData',compact("couCourses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('couCourses.create');
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
      $img->move(public_path('uploads/couCourses'), $name);


     Course::create([
       'name' => $request->name,
       'email' => $request->email,
       'address' => $request->address,
       'gender' => $request->gender,
       'image' => $name,
       'grade' => $request->grade,
      ]);

      
      return to_route('couCourses.index');

      
     


    }
   

    /**
     * Display the specified resource.
     */

    
     function view($id)
     {
       $couCourse=Course::findOrFail($id);
       return view('couCourses.couCourseData',compact("couCourse"));
     }
 
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $couCourse=Course::findOrFail($id);
        return view('couCourses.update',compact("couCourse"));
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
    
        $couCourse =Course::findOrFail($id);
    
       
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = uniqid() . '.' . $ext;
            $img->move(public_path('uploads/couCourses'), $name);
            $couCourse->image = $name;
        }
    
       
        $couCourse->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'grade' => $request->grade,
        ]);
    
       
        $couCourse->save();
    
        return redirect()->route('couCourses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $couCourse=Course::findOrFail($id);
         $couCourse->delete();
         return to_route('couCourses.index');
    }
}
