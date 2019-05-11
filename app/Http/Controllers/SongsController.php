<?php

namespace App\Http\Controllers;

use App\Models\Lyric;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Song;
use App\Models\Album;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Validator;

class SongsController extends Controller
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
     * Show the admin songs.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $songs = Song::with('album', 'photo', 'lyric')->paginate(15);

        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        $albums = Album::all();

        return view('admin.songs.create', compact('albums'));
    }

    public function edit($id)
    {
        $song = Song::where('id', $id)->with('album', 'lyric', 'photo')->first();

        return view('admin.songs.edit', [
            'id' => $id,
            'song' => $song,
        ]);
    }

    public function show($id)
    {
        $song = Song::findOrFail($id)->with('album', 'photo', 'lyric')->first();

        return view('admin.songs.show', [
                'id' => $id,
                'song' => $song,
            ]);
    }

    public function  delete($id)
    {
        $song = Song::findOrFail($id);

        return redirect()->route('songs')->with('success', 'Песня "'.$song->name.'" удалена');
    }

    public function update(Request $request)
    {

        $id = $request->id;
        $name = $request->name;
        $album = $request->album ?? 'Нет_альбома';

        if ($request->hasFile('song')) {
            $song = $request->file('song');
            $songName = $song->getClientOriginalName();
            $songExt = $song->getClientOriginalExtension();
            $songSize = $song->getSize();
            $songPath = $request->song->storeAs('public', 'songs/'.$album.'/'.$songName);
            //$file->store('public/'.$request->album);
        }

        /*DB::table('users')
            ->where('id', $id)
            ->update(['votes' => 1]);*/
        return redirect('admin.songs.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'album' => 'string|max:255|nullable',
            'date' => 'date',
            'description' => 'string|nullable',
            'photo' => 'image|mimes:jpeg,jpg,png|nullable',
            'file' => 'mimes:mp3,mpga,mpeg',
        ], $messages = [
            'name.required' => 'Название песни не может быть пустым!',
            'name.min' => 'Не менее 3-х символов!',
            'song.mimes' => 'Только mp3 файлы!',
            'photo.mimes' => 'Только jpeg,jpg,png файлы!',
            'date.date' => 'Неверный формат даты!'
        ])->validate();

        $album = $request->album;

        if ($request->hasFile('song')) {
            $song = $request->file('song');
            $songName = $song->getClientOriginalName();
            $songSize = $song->getSize();
            $songPath = 'songs/'.$album.'/'.$songName;
            $request->song->storeAs('public', $songPath);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $size = $photo->getSize();
            $photoName = $photo->getClientOriginalName();
            $pathPhoto = 'photos/'.$album.'/'.$photoName;
            $request->photo->storeAs('public', $pathPhoto);
            $newPhoto = Photo::create([
                'size' => $size,
                'path' => 'storage/'.$pathPhoto
            ]);
        }

        if ($request->lyrics) {
            $newLyrics = Lyric::create([
                'text' => $request->lyrics
            ]);
        }

        $newSong = Song::create([
            'name' => $request->name,
            'path' => 'storage/'.$songPath,
            'size' => $songSize,
            'album_id' => $request->album,
            'photo_id' => $newPhoto->id,
            'lyric_id'=> $newLyrics->id,
            'description'=> $request->description,
            'date'=> $request->date,
        ]);

        return redirect()->route('songs')->with('success', 'Песня ' .$songName. ' успешно добавлена в базу');
    }
}
