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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
        $fileSize = round(Song::sum('size')/1000000, 2);

        return view('admin.songs.index', compact('songs'), compact('fileSize'));
    }

    public function create()
    {
        $albums = Album::all();

        return view('admin.songs.create', compact('albums'));
    }

    public function edit($id)
    {
        $song = Song::with('album', 'lyric', 'photo')->where('id', $id)->first();
        $albums = Album::all();

        return view('admin.songs.edit', [
            'id' => $id,
            'song' => $song,
            'albums' => $albums
        ]);
    }

    public function show($id)
    {
        $song = Song::with('album', 'photo', 'lyric')->where('id', $id)->first();

        return view('admin.songs.show', [
                'id' => $id,
                'song' => $song,
            ]);
    }

    public function delete($id)
    {
        $song = Song::with('photo', 'lyric')->where('id', $id)->first();

        if (!Storage::disk('public')->delete($song->photo->path)) {
            $error = 'Файл ['.$song->photo->path.'] не был удален';
        }

        if (!Storage::disk('public')->delete($song->path)) {
            $error = 'Файл ['.$song->path.'] не был удален';
        }
        $song->photo->delete();
        $song->lyric->delete();
        $song->delete();

        if (isset($error)) {
            return redirect()->route('songs')->with('error', $error);
        }

        return redirect()->route('songs')->with('success', 'Песня "'.$song->name.'" удалена');
    }

    public function update(Request $request)
    {
        $this->validateForm($request->all());
        $songId = $request->songId;
        $thisSong = Song::with('photo')->findOrFail($songId);
        $album = Album::findOrFail($thisSong->album_id);
        $lyric = Lyric::findOrFail($thisSong->lyric_id);
        $lyric->text = $request->lyrics;
        $lyric->save();

        if ($request->hasFile('song')) {
            $song = $request->file('song');
            $songName = $song->getClientOriginalName();
            $songSize = $song->getSize();
            $songPath = 'songs/'.$album->id.'/'.$songName;
            Storage::disk('public')->delete($thisSong->path);
            $request->song->storeAs('public', $songPath);
            $thisSong->size = $songSize;
            $thisSong->path = $songPath;
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoSize = $photo->getSize();
            $photoName = $photo->getClientOriginalName();
            $photoPath = 'photos/'.$album->id.'/'.$photoName;
            Storage::disk('public')->delete($thisSong->photo->path);
            $request->photo->storeAs('public', $photoPath);
            $thisPhoto = Photo::findOrFail($thisSong->photo_id);
            $thisPhoto->path = $photoPath;
            $thisPhoto->size = $photoSize;
            $thisPhoto->save();
        }

        $thisSong->name = $request->name;
        $thisSong->album_id = $request->album;
        $thisSong->show = $request->show == 'on' ? 1 : 0;
        $thisSong->uploaded = $request->date;
        $thisSong->description = $request->description;
        $thisSong->save();

        return redirect()->route('songs')
            ->with('success', 'Песня ' .$request->name. ': изменения успешно сохранены.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm($request->all());

        $albumId = $request->album;

        if ($request->hasFile('song')) {
            $song = $request->file('song');
            $songName = $song->getClientOriginalName();
            $songSize = $song->getSize();
            $songPath = 'songs/'.$albumId.'/'.$songName;

            $request->song->storeAs('public', $songPath);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $size = $photo->getSize();
            $photoName = $photo->getClientOriginalName();
            $pathPhoto = 'photos/'.$albumId.'/'.$photoName;
            $request->photo->storeAs('public', $pathPhoto);
            $newPhoto = Photo::create([
                'size' => $size,
                'path' => $pathPhoto
            ]);
        }

        if ($request->lyrics) {
            $newLyrics = Lyric::create([
                'text' => $request->lyrics
            ]);
        }

        $newSong = Song::create([
            'name' => $request->name,
            'path' => $songPath,
            'size' => $songSize,
            'album_id' => $albumId,
            'photo_id' => $newPhoto->id,
            'lyric_id'=> $newLyrics->id,
            'description'=> $request->description,
            'date'=> $request->date,
        ]);

        return redirect()->route('songs')->with('success', 'Песня ' .$songName. ' успешно добавлена в базу');
    }

    private function validateForm($input) {
        $validator = Validator::make($input, [
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
    }
}
