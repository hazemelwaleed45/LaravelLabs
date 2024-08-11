<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Track</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<x-NAV> Update Track</x-NAV>
    <h1 class="text-center text-bold m-5">Update Track {{$track->id}}</h1>
    <form class="border p-2 bordered w-75 m-auto" method="post" action="{{route('tracks.update', $track->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
      
        <div class="mb-3">
          <label for="exampleInputName1" class="form-label">Name</label>
          <input name="name" type="text" class="form-control" id="exampleInputName1" aria-describedby="NameHelp">
        </div>
    
        <div class="mb-3">
          <label for="exampleInputLocation1" class="form-label">Location</label>
          <input name="location" type="text" class="form-control" id="exampleInputLocation1" aria-describedby="LocationHelp">
        </div>
        
        <div class="mb-3">
          <label for="exampleInputCN1" class="form-label">Courses Number</label>
          <input name="coursesnumber" type="number" class="form-control" id="exampleInputCN1" aria-describedby="CNHelp">
        </div>
        
        <div class="mb-3">
          <label for="exampleInputType1" class="form-label">Type</label>
          <input name="type" type="text" class="form-control" id="exampleInputType1" aria-describedby="TypeHelp">
        </div>

        <div class="mb-3">
          <label for="exampleInputImage1" class="form-label">Image</label>
          <input name="image" type="file" class="form-control" id="exampleInputImage1" aria-describedby="ImageHelp">
        </div>
      
        <div class="mb-3">
          <label for="exampleInputphone1" class="form-label">Phone</label>
          <input name="phone" type="text" class="form-control" id="exampleInputphone1" aria-describedby="phoneHelp">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
