@extends('master')
@section('content')

<!--Update page-->
<div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3">
            <div class="my-3">
               <a href="{{route('post#home')}}" class="text-black" style="text-decoration: none">
                <i class="fa-solid fa-arrow-left"></i> back
               </a>
            </div>

            <h3>{{$post->title}}</h3>
            <div class="d-flex">
                <div class="btn btn-dark text-white me-2 my-3"><i class="fa-solid fa-money-bill-1 text-success"></i> {{$post->price}}</div>
                <div class="btn btn-dark text-white me-2 my-3"><i class="fa-solid fa-location-dot text-primary"></i> {{$post->address}}</div>
                <div class="btn btn-dark text-white me-2 my-3"><i class="fa-solid fa-star text-info"></i> {{$post->rating}}</div>
                <div class="btn btn-dark text-white me-2 my-3"><i class="fa-solid fa-calendar-day"></i> {{$post->created_at->format("j-F-Y")}}</div>
                <div class="btn btn-dark text-white me-2 my-3"><i class="fa-solid fa-clock"></i> {{$post->created_at->format("h:m:s:A")}}</div>
            </div>
            <label for=""><h3>Photo</h3></label>
            <div class="">
                @if ($post->photo == null)
                <img src="{{asset('404_image.png')}}" class="img-thumbnail my-4 shadow-sm"  >
                @else
                <img src="{{asset('storage/'.$post->photo)}}" class="img-thumbnail my-4 shadow-sm"  >
                @endif
            </div>
            <p class="text-muted">{{$post->description}}</p>
            {{-- <p class="text-muted">{{$post->price | $post->address | $post->rating}}</p> --}}


        </div>
    </div>
    <div class="row my-3">
        <div class="col-3 offset-8">
            <a href="{{url('post/editPage/'.$post['id'])}}">
                <button class="btn bg-dark text-white ">Edit</button>
            </a>
        </div>
    </div>
</div>

@endsection
