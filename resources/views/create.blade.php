@extends('master')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-5">
                <div class="p-3">

                    @if (session('insertSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('insertSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('updateSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>{{ session('updateSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                    <form action="{{ route('post#create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-group mb-3 ">
                            <label for="">
                                Post Title
                            </label>
                            <input type="text" name="postTitle"
                                class="form-control @error('postTitle') is-invalid  @enderror"
                                value="{{ old('postTitle') }}" placeholder="Enter Post Title...">

                            @error('postTitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                    {{-- Looks bad! --}}
                                </div>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">
                                Post Description
                            </label>
                            <textarea name="postDescript" placeholder="Enter Post Description..." cols="30" rows="10"
                                class="form-control @error('postDescript') is-invalid  @enderror">{{ old('postDescript') }}</textarea>
                            @error('postDescript')
                                <div class="invalid-feedback">
                                    {{-- Looks bad! --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                        <label for="">
                            Photo
                        </label>
                        <input type="file" name="postPhoto" class="form-control @error('postFee') is-invalid  @enderror"
                         value="{{old('postPhoto')}}" placeholder="Enter Post Photo..." >
                         @error('postPhoto')
                         <div class="invalid-feedback">
                             {{-- Looks bad! --}}
                             {{ $message }}
                         </div>
                     @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">
                                Fee
                            </label>
                            <input type="number" name="postFee"
                                class="form-control  @error('postFee') is-invalid  @enderror" value="{{ old('postFee') }}"
                                placeholder="Enter Post Fee...">
                            @error('postFee')
                                <div class="invalid-feedback">
                                    {{-- Looks bad! --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">
                                Address
                            </label>
                            <input type="text" name="postAddress"
                                class="form-control  @error('postAddress') is-invalid  @enderror"
                                value="{{ old('postAddress') }}" placeholder="Enter Post Address...">
                            @error('postAddress')
                                <div class="invalid-feedback">
                                    {{-- Looks bad! --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">
                                Rating
                            </label>
                            <input type="number" name="postRating" min="0" max="5"
                                class="form-control  @error('postRating') is-invalid  @enderror"
                                value="{{ old('postRating') }}" placeholder="Enter Post Rating...">
                            @error('postRating')
                                <div class="invalid-feedback">
                                    {{-- Looks bad! --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="">
                            <input type="submit" value="Create" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7 ">
                <h3 class="mb-3">
                    <div class="row">
                        <div class="col-5">Total -> {{ $posts->total() }}</div>
                        <div class="col-5 offset-2">

                            <form action="{{ route('post#createPage') }}" method="GET">
                                <div class="row">
                                    <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                        class="col form-control" placeholder="Enter Search Key...">
                                    <button class="btn btn-danger col-2" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>
                </h3>
                <div class="data-container">
                    @if (count($posts) != 0)
                        @foreach ($posts as $items)
                            <div class="post p-3 shadow-sm mb-4">
                                <div class="row">
                                    <h5 class="col-7">{{ $items->title }}</h5>
                                    <h5 class="col-4 offset-1">{{ $items->created_at->format('j-F-Y') }}</h5>
                                    {{-- <div class="col"> {{$items['created_at']}}</div> --}}
                                </div>
                                {{-- <p class="text-muted ">{{substr($items['description'],0,100)}}</p> --}}
                                <p class="text-muted">{{ Str::words($items->description, 20, '...') }}</p>
                                <!--same meaning as above but in laravel method-->
                                <span>
                                    <small><i class="fa-solid fa-money-bill-1 text-success"></i> {{ $items->price }}
                                        kyats</small>
                                </span> |
                                <span>
                                    <i class="fa-solid fa-location-dot text-primary"></i> {{ $items->address }}
                                </span> |
                                <span>
                                    {{ $items->rating }}<i class="fa-solid fa-star text-info"></i>
                                </span>
                                <div class="text-end">
                                    <a href="{{ url('/post/delete/' . $items->id) }}">
                                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>To
                                            Delete</button></a>
                                    <a href="{{ url('post/updatePage/' . $items->id) }}">
                                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-file-lines"></i>To
                                            Read</button></a>
                                    <!--Route::get method-->
                                    {{-- <form action="{{url('/post/delete/'.$items['id'])}}" method="POST">
                           @csrf
                           @method('delete')
                           <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>To Delete</button>
                       </form>
                       <button class="btn btn-sm btn-primary"><i class="fa-solid fa-file-lines"></i>To Read</button>
                   </div><!--Route::delete method--> --}}
                                </div>
                            </div>
                        @endforeach
                        {{-- @for ($i = 0; $i < count($posts); $i++)
                  <div class="post p-3 shadow-sm mb-4">
                   <h5>{{$posts[$i]['title']}}</h5>
                   <p class="text-muted">{{$posts[$i]['description']}}</p>
                   <div class="text-end">
                       <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                       <button class="btn btn-sm btn-primary"><i class="fa-solid fa-file-lines"></i></button>
                   </div>
           </div>
                  @endfor --}}
                    @else
                        <h3 class="text-danger text-center mt-5 ">There is no data...</h3>
                    @endif

                </div>
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    @endsection
