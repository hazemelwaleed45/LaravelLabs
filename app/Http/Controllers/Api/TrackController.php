<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrackResource;
use Illuminate\Http\Request;
use App\Models\Track;
class TrackController extends Controller
{
    
    public function index()
    {
        $tracks=Track::all();
        return TrackResource::collection($tracks);
    }

    public function show($id)
     {
       $track=Track::findOrFail($id);
       return new TrackResource($track);
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
       
      return TrackResource::collection(Track::all());



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
        $track->update( $request->all());
         
        $track->save();
    
        
       return new TrackResource($track);
        
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
    
    return TrackResource::collection(Track::all());

}

}
