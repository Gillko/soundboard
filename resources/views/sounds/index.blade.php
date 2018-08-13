@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
	        	<a href="{{ route('sounds.create') }}">
	            	<button class="btn btn-primary">
	                	{{ __('Upload Audio file') }}
	            	</button>
	            </a>
			    <br>
				@foreach($sounds as $sound)
					<a href="{{ URL::to('/sounds/' . $sound->id) }}">{{ $sound->title }}</a>
			       <!--  <audio id="{{ $sound->title }}" src="{{ asset('uploads/audiofiles/') }}/{{ Auth::user()->firstname }}-{{ Auth::user()->surname }}-{{ Auth::user()->email }}/{{ $sound->audio }}"></audio>
			        <button class="btn btn-own" onclick="document.getElementById('{{ $sound->title }}').play()" style="background-color:{{ $user->color }};color:#fff;">{{ $sound->title }}</button> -->
			        <br>
			    @endforeach
			</div>
		</div>
	</div>
</div>
@endsection