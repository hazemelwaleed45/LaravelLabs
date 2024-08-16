<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses=Course::orderBy('id',"asc")->paginate(5);
        return view('courses.coursesData',compact("courses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create' , ['tracks' =>Track::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    function store( Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:courses,name|min:3',
            'totalgrade' => 'required',
            'description' => 'required|min:50',
            'track_id' => 'required',
        ],[
            'name.unique' => "This course name already exists",
            'name.min' => "Course name must be at least 3 characters",
            'description.min' => 'The course description is too short',
            'totalgrade.required' => 'You must input the total grade',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    


     Course::create([
       'name' => $request->name,
       'description' => $request->description,
       'totalgrade' => $request->totalgrade,
       'track_id' => $request->track_id,
      ]);
      return to_route('courses.index');
    }
   

    /**
     * Display the specified resource.
     */

    
     function show($id)
     {
       $course=Course::findOrFail($id);
       return view('courses.courseData',compact("course"));
     }
 
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $course = Course::findOrFail($id);  
    $tracks = Track::all();             

    return view('courses.update', compact('course', 'tracks'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:courses,name|min:3',
            'totalgrade' => 'required',
            'description' => 'required|min:50',
            'track_id' => 'required',
        ],[
            'name.unique' => "This course name already exists",
            'name.min' => "Course name must be at least 3 characters",
            'description.min' => 'The course description is too short',
            'totalgrade.required' => 'You must input the total grade',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $Course =Course::findOrFail($id);
    
       
       
    
       
        $Course->update([
            'name' => $request->name,
            'description' => $request->description,
            'totalgrade' => $request->totalgrade,
            'track_id' => $request->track_id,
           
        ]);
    
       
        $Course->save();
    
        return redirect()->route('Courses.index');
    }

    
    public function destroy($id)
    {
        $course=Course::findOrFail($id);
         $course->delete();
         return to_route('courses.index');
    }

   
}
