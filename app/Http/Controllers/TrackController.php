<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Track;

class TrackController extends Controller
{
    function index()
    {
     
        //  $tracks=DB::table('track')->get();

        $tracks=Track::all();
        
        return view('tracks.tracksData',compact("tracks"));
    }


    function view($id)
    {
      $track=Track::find($id);
      return view('tracks.trackData',compact("track"));
    }

    public function destroy($id)
    {
        $track = Track::find($id);
        $track->delete();

        return redirect()->route('tracks.index')->with('success', 'Track deleted successfully');
    }

    function create()
    {
       return view('tracks.create');
    }

    function store( Request $request)
    {
      
  
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


    function update(Request $request, $id)
     {
    
        $track = Track::findOrFail($id);
    
       
        if ($request->hasFile('image')) {
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



      
     

}