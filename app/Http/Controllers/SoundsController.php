<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadFile;
use App\User;
use App\Sound;
use Auth;

class SoundsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'audio' => 'required|string|max:255',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $loggedInUser = Auth::user()->id;

        $sounds = Sound::all()->where('user_id', $loggedInUser);

        return \View::make('sounds.index')->with(['user' => Auth::user(), 'sounds' => $sounds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sounds = Sound::all();

        return \View::make('sounds.create')->with(['user' => Auth::user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sound = new Sound;

        $sound->title = $request->title;

        if($request->hasFile('audio')){
            $audio = $request->file('audio');
            
            $user = Auth::user();

            $filename = 'audio-' . time() . '-' . $user->firstname . '-' . $user->surname . '-' . $user->nickname . '.' . $audio->getClientOriginalExtension();

            $location = public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email);

            //$location = public_path('/uploads/audiofiles/');

            $audio->move($location,$filename);

            $sound->audio = $filename;
            $sound->user_id = Auth::user()->id;
        }

        $sound->save();
        //return view('profile', ['user' => Auth::user()]);

        return redirect('sounds')->with('success','The Audio file has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sound = Sound::find($id);
        return \View::make('sounds.show')->with(['sound' => $sound, 'user' => Auth::user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sound = Sound::find($id);
        return view('sounds.edit',compact('sound','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sound = Sound::find($id);
        $sound->title = $request->get('title');
        
        if($request->hasFile('audio')){
            $audio = $request->file('audio');
            $user = Auth::user();

            $oldFile = $sound->audio;

            $user = Auth::user();

            if(file_exists(public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile))){
                unlink(public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile));
            }

            $filename = 'audio-' . time() . '-' . $user->firstname . '-' . $user->surname . '-' . $user->nickname . '.' . $audio->getClientOriginalExtension();
            $location = public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email);
            $audio->move($location,$filename);
            $sound->audio = $filename;
        }

        $sound->update();

        return redirect('sounds')->with('success','The Audio file has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sound = Sound::find($id);

        $user = Auth::user();

        //===deleting the old File===//
        $oldFile = $sound->audio;

        if(file_exists(public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile))){
            unlink(public_path('/uploads/audiofiles/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile));
        }
        //===deleting the old File===//

        $sound->delete();
        return redirect('sounds')->with('success','The Audio file has been deleted');
    }
}
