<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CourseController extends Controller
{
    public function index()
    {
        $courses=Course::all();
        return CourseResource::collection($courses);
    }

    public function show($id)
     {
       $course=Course::findOrFail($id);
       return new CourseResource($course);
     }


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
      
      return CourseResource::collection(Course::all());

    }
   

  
  

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
    
        $Course->update($request->all());
      
        $Course->save();
    
        return new CourseResource($Course);

    }

    
    public function destroy($id)
    {
        $course=Course::findOrFail($id);
         $course->delete();
         return CourseResource::collection(Course::all());

    }
}
