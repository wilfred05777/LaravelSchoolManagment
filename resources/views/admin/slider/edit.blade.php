@extends('admin.admin_master')

@section('admin')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times</span>
            </button>
        </div>
    @endif
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Update Slider</h2>
            </div>
            <div class="card-body">
                {{-- <form action="{{ route('store.slider') }}" method="POST" enctype="multipart/form-data"> --}}
                <form action="{{ url('slider/update/' . $sliders->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="old_image" value="{{ $sliders->image }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Update Slider Title</label>
                        <input value="{{ $sliders->title }}" name="title" type="text" class="form-control"
                            id="exampleFormControlInput1" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Update Slider Description</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                            rows="3">{{ $sliders->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Update Slider Image</label>
                        <input name="image" value="{{ $sliders->image }}" type="file" class="form-control-file">
                        <div class="form-group mt-3">
                            <img src="{{ asset($sliders->image) }}" style="width: 400; height:200px" />
                        </div>
                    </div>
                    <div class="form-footer pt-4 pt-5 mt-4 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection()
