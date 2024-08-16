<?php

namespace App\Http\Controllers\Api;

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
}
