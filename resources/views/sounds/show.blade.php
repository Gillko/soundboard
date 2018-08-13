@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	<a href="{{ URL::to('/sounds/' . $sound->id . '/edit') }}">
	            	<button class="btn btn-primary">
	                	{{ __('Update Audio file') }}
	            	</button>
	            </a>
	            <form method="POST" action="{{route('sounds.destroy', $sound->id)}}">
	            	@csrf 
	            	{{ method_field('DELETE') }} 
	            	<input class="btn btn-danger" value="Delete Audio file" type="submit">
	            </form>

	            <br>
		        <audio id="{{ $sound->title }}" src="{{ asset('uploads/audiofiles/') }}/{{ Auth::user()->firstname }}-{{ Auth::user()->surname }}-{{ Auth::user()->email }}/{{ $sound->audio }}"></audio>
		        <button class="btn btn-own" onclick="document.getElementById('{{ $sound->title }}').play()" style="background-color:{{ $user->color }};color:#fff;">{{ $sound->title }}</button>
			</div>
		</div>
	</div>
</div>
@endsection