<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Track;

use Illuminate\Support\Facades\Validator;

class TrackController extends Controller
{
    function index()
    {
     
        //  $tracks=DB::table('track')->get();

        $tracks=Track::all();
        
        return view('tracks.tracksData',compact("tracks"));
    }


    function show($id)
    {
      $track=Track::find($id);
      $courses =$track->courses;
      $students =$track->students;
      return view('tracks.trackData',compact("track" , "courses" , "students"));
    }

   

    function create()
    {
       return view('tracks.create');
    }

    function store( Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:track,name|min:3',
            'coursesnumber' => 'required',
            'location' => 'required|unique:track,location',
            'type' => 'required',
            'phone' => 'required',
            'image' => 'required|image',
        ],[
            'name.unique' => "This course name already exists",
            'name.min' => "Track course name must be at least 3 characters",
            'location.required' => 'Location is required',
            'location.unique' => 'This location already exists',
            'coursesnumber.required' => 'You must input the number of courses',
            'type.required' => 'Type is required (e.g., .NET or PHP)',
            'phone.required' => 'Phone is required',
            'image.required' => 'Image is required',
            'image.image' => 'The file must be an image',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
  
      $img = $request->file('image');
      $ext = $img->getClientOriginalExtension();
      $name = uniqid() . '.' . $ext;
      $img->move(public_path('uploads/tracks'), $name);


      Track::create([
       'name' => $request->name,
       'location' => $request->location,
       'coursesnumber' => $request->coursesnumber,
       'type' => $request->type,
       'image' => $name,
       'phone' => $request->phone,
      ]);
       return to_route('tracks.index');


    }
 
    function edit($id)
    {
       $track=Track::findOrFail($id);
       return view('tracks.update',compact("track"));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:track,name|min:3',
            'coursesnumber' => 'required',
            'location' => 'required|unique:track,location',
            'type' => 'required',
            'phone' => 'required',
            'image' => 'required|image',
        ],[
            'name.unique' => "This course name already exists",
            'name.min' => "Track course name must be at least 3 characters",
            'location.required' => 'Location is required',
            'location.unique' => 'This location already exists',
            'coursesnumber.required' => 'You must input the number of courses',
            'type.required' => 'Type is required (e.g., .NET or PHP)',
            'phone.required' => 'Phone is required',
            'image.required' => 'Image is required',
            'image.image' => 'The file must be an image',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $track = Track::findOrFail($id);
    
   
        if ($request->hasFile('image')) {
         
            if ($track->image) {
                $oldImagePath = public_path('uploads/tracks/' . $track->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = uniqid() . '.' . $ext;
            $img->move(public_path('uploads/tracks'), $name);
    
            $track->image = $name;
        }
        $track->update([
            'name' => $request->name,
            'location' => $request->location,
            'coursesnumber' => $request->coursesnumber,
            'type' => $request->type,
            'phone' => $request->phone,
        ]);
        $track->save();
    
        
        return redirect()->route('tracks.index');
    }
    

    public function destroy($id)
{
   
    $track = Track::findOrFail($id);
    if ($track->image) {
      
        $imagePath = public_path('uploads/tracks/' . $track->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    $track->delete();
    return redirect()->route('tracks.index')->with('success', 'Track deleted successfully');
}




      
     

}