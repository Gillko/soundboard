@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="">

                <?php 
                    $sounds = \App\Sound::all();
                    $soundsArray = [];
                    foreach ($sounds as $sound) {
                        array_push($soundsArray, $sound->id);
                    }
                ?>

                <script>
                    var soundsArray =    <?php 
                                        echo '
                                                ["' 
                                                . 
                                                    implode(
                                                        '", "', $soundsArray
                                                )
                                                .
                                                '"];'
                                    ; ?>;
                </script>
                   
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($users as $user)
                        
                        @if($user->nickname != 'ADG')
                        <h1 style="margin: 0 auto;">{{ $user->nickname }}</h1>
                        <br>
                        
                        @if($user->avatar == 'user.jpg')
                        <img src="{{ asset('uploads/avatars') }}/{{ $user->avatar }}" alt="{{ $user->nickname }}" style="width:150px; margin:0 auto;">
                        @else
                        <img src="{{ asset('uploads/avatars') }}/{{ $user->firstname }}-{{ $user->surname }}-{{ $user->email }}/{{ $user->avatar }}" alt="{{ $user->nickname }}" style="width:150px; margin:0 auto;">
                        @endif
                        <br>
                        
                        @foreach($user->audios as $audio)
                        <div class="row" style="padding-right:15px;padding-left:15px;">
                            <div class="col-md-11" style="padding-right:0px;padding-left:0px;">
                                <audio id="{{ $audio->id }}" src="{{ asset('uploads/audiofiles/') }}/{{ $user->firstname }}-{{ $user->surname }}-{{ $user->email }}/{{ $audio->audio }}"></audio>
                                <button class="btn btn-own" onclick="document.getElementById('{{ $audio->id }}').play()" style="background-color:{{ $user->color }};color:#fff;">{{ $audio->title }}</button>
                            </div>
                            <div class="col-md-1" style="padding-right:0px;padding-left:0px;">
                                <button onclick="{{ str_replace(array('!', ',', ' ', '.', '&', '-', '?', '(', ')'), '',$audio->title) }}()" class="btn btn-own" style="color:{{ $user->color }};"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                                <input type="text" id='{{ $audio->id }}-clipboard' style="height:0px;line-height:0;padding:0;margin:0;width:10px;border: none;opacity:0">

                                <style>
                                    button{
                                        width: 100%;
                                    }
                                </style>
                                <script>
                                    var i;
                                    for(i = 0; i < soundsArray.length; ++i) {

                                        var clipboard = document.getElementById('{{ $audio->id }}').src;

                                        document.getElementById('{{ $audio->id }}-clipboard').value = clipboard;

                                       function {{ str_replace(array('!', ',', ' ', '.', '&', '-', '?', '(', ')'), '',$audio->title) }}() {
                                          /* Get the text field */
                                          var copyText = document.getElementById("{{ $audio->id }}-clipboard");

                                          var clipboard = document.getElementById('{{ $audio->id }}').src;

                                          /* Select the text field */
                                          copyText.select();

                                          /* Copy the text inside the text field */
                                          document.execCommand("copy");

                                          /* Alert the copied text */
                                          alert("Copied the text: " + copyText.value);
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <br>
                        @endforeach

                        @endif
                    
                    @endforeach
                
            </div>
        </div>
    </div>
</div>
@endsection
