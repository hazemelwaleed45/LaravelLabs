<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;


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

     public function store(Request $request)
     {
      // dd($request);
          $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'address' => 'required',
            'email' => 'required|email|unique:students,email',
            'gender' => 'required',
            'image' => 'required|image',
            'grade' => 'required',
        ], [
            'name.required' => "Enter The Name",
            'name.min' => "Name must be at least 3 characters",
            'email.required' => 'Email is Required',
            'email.unique' => 'This Email is already exist',
            'email.email' => 'Invalid Format',
            'address.required' => 'You must input Address',
            'grade.required' => 'Must Enter Grade',
            'gender.required' => 'You must select your Gender',
            'image.required' => 'Image is Required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
      $img = $request->file('image');
      $ext = $img->getClientOriginalExtension();
      $name = uniqid() . '.' . $ext;
      $img->move(public_path('uploads/students'), $name);

      Student::create([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'gender' => $request->gender,
        'image' => $request->name,
        'grade' => $request->grade,
        'track_id'=>$request->track_id ,
       ]);
       return StudentResource::collection(Student::all());
     }

     public function update(Request $request, $id)
     {


        //  dd($request);
        //  $validator = Validator::make($request->all(), [
        //      'name' => 'required|min:3',
        //      'address' => 'required',
        //      'email' => 'required|email|unique:students,email',
        //      'gender' => 'required',
        //      'image' => 'required|image',
        //      'grade' => 'required',
        //  ], [
        //      'name.required' => "Enter The Name",
        //      'name.min' => "Name must be at least 3 characters",
        //      'email.required' => 'Email is Required',
        //      'email.unique' => 'This Email is already exist',
        //      'email.email' => 'Invalid Format',
        //      'address.required' => 'You must input Address',
        //      'grade.required' => 'Must Enter Grade',
        //      'gender.required' => 'You must select your Gender',
        //      'image.required' => 'Image is Required',
        //  ]);
         
        //  if ($validator->fails()) {
        //      return redirect()->back()
        //          ->withErrors($validator)
        //          ->withInput();
        //  }
     
      
         $student = Student::findOrFail($id);
     
        
        //  if ($request->hasFile('image')) {
             
        //      if ($student->image) {
        //          $oldImagePath = public_path('uploads/students/' . $student->image);
        //          if (file_exists($oldImagePath)) {
        //              unlink($oldImagePath);
        //          }
        //      }
     
            
        //      $img = $request->file('image');
        //      $ext = $img->getClientOriginalExtension();
        //      $name = uniqid() . '.' . $ext;
        //      $img->move(public_path('uploads/students'), $name);
     
            
        //      $student->image = $name;
        //  }
     
        
         $student->update($request->all());
     
        
         $student->save();
     
         return new StudentResource($student);

     }

     public function destroy($id)
     {
        
         $student = Student::findOrFail($id);
        //  dd($student);
     
         if ($student->image) {
          
             $imagePath = public_path('uploads/students/' . $student->image);
        
             if (file_exists($imagePath)) {
                 unlink($imagePath);
             }
         }
 
         $student->delete();
   
       return StudentResource::collection(Student::all());
         
     }
     
 
 
}
