@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $sound->title }}</div>
                <div class="card-body">
                    <form method="post" action="{{action('SoundsController@update', $id)}}" enctype="multipart/form-data">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input id=title type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $sound->title }}">

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Audio File</label>

                            <div class="col-md-6">
                                <input id="audio" type="file" class="form-control{{ $errors->has('audio') ? ' is-invalid' : '' }}" name="audio" value="{{ old('audio') }}" required autofocus>

                                @if ($errors->has('audio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('audio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Audio File') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection