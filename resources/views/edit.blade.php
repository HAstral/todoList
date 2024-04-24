@extends('master')
@section('content')

<!--Update page-->
<div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3">
            <div class="my-3">
               <a href="{{url('post/updatePage/'.$post['id'])}}" class="text-black" style="text-decoration: none">
                <i class="fa-solid fa-arrow-left"></i> back
               </a>
            </div>
            <form action="{{url('post/update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">Post Title</label>
                <input type="hidden" name="postId" value="{{$post['id']}}">
                <input type="text" name="postTitle" placeholder="Enter..."  class="my-3 form-control @error('postTitle') is-invalid  @enderror" value="{{old('postTitle',$post['title'])}}">
                @error('postTitle')
                <div class="invalid-feedback mb-3">
                    {{$message}}
                    {{-- Looks bad! --}}
                  </div>

              @enderror
              <label for="">Photo</label>
              <div class="">
                @if ($post['photo'] == null)
                <img src="{{asset('404_image.png')}}"  class="img-thumbnail mt-4 shadow-sm"  >
                @else
                <img src="{{asset('storage/'.$post['photo'])}}" class="img-thumbnail mt-4 shadow-sm"  >
                @endif
            </div>
            <input type="file" name="postPhoto" class="mb-4 form-control @error('postFee') is-invalid  @enderror"
                         value="{{old('postPhoto')}}" placeholder="Enter Post Photo..." >
                         @error('postPhoto')
                         <div class="invalid-feedback">
                             {{-- Looks bad! --}}
                             {{ $message }}
                         </div>
                        @enderror
                <label for="">Post Description</label>
                <textarea class="form-control my-3 @error('postDescript') is-invalid  @enderror" placeholder="Enter..."  name="postDescript" id="" cols="30" rows="10">{{old('postDescript',$post['description'])}}</textarea>
                @error('postDescript')
                <div class="invalid-feedback">
                    {{-- Looks bad! --}}
                    {{$message}}
                  </div>
              @enderror
              <!--<label for="">
                Photo
            </label>
              <input type="file" name="postPhoto" class="form-control "
                         {{-- value="{{old('postPhoto')}}" placeholder="Enter Post Photo..." > --}}-->

              <label for="">
                Fee
            </label>
            <input type="number" name="postFee"
                class="form-control my-3" value="{{ old('postFee',$post['price']) }}"
                placeholder="Enter Post Fee...">
            {{-- @error('postFee')
            <div class="invalid-feedback">
                {{-- Looks bad! --}}
                 {{-- {{ $message }} --}}
            {{-- </div> --}}
        {{-- @enderror --}}

        <label for="">
            Address
        </label>
        <input type="text" name="postAddress"
            class="form-control my-3"
            value="{{ old('postAddress',$post['address']) }}" placeholder="Enter Post Address...">
        {{-- @error('postAddress')
            <div class="invalid-feedback"> --}}
                {{-- Looks bad! --}}
                {{-- {{ $message }}
            </div>
        @enderror --}}

        <label for="">
            Rating
        </label>
        <input type="number" name="postRating" min="0" max="5"
            class="form-control my-3"
            value="{{ old('postRating',$post['rating']) }}" placeholder="Enter Post Rating...">
        {{-- @error('postRating')
            <div class="invalid-feedback"> --}}
                {{-- Looks bad! --}}
                {{-- {{ $message }}
            </div>
        @enderror --}}

                <input type="submit" value="Update" class="btn btn-danger my-3 float-end">
            </form>
        </div>
    </div>

</div>

@endsection
