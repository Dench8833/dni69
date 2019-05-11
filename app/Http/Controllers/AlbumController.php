<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
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
        $albums = Album::all();

        return view('admin.albums.index', compact('albums'));
    }

    public function ajaxAlbum(Request $request)
    {
        $action = $request->action;
        $name = $request->name;
        $id = $request->id;

        if ($action == 'delete' && $id !== 'album-new_row') {

            $album = Album::find($id);
            $data = $album->toArray();
            //dd($data);
            $data['action'] = $action;
            $album->delete();

            return json_encode($data);
        }

        if ($action == 'save') {
            $request->validate([
                'name' => 'required|string|between:3,100'
            ]);

            $album = new Album([
                'name' => $name,
            ]);

            $album->save();
            $data = $album->toArray();
            $data['action'] = $action;

            return json_encode($data);
        }

        if ($action == 'update') {
            $album = Album::find($request->id);
            $album->fill($request->all())->save();
            $data = $album->toArray();
            $data['action'] = $action;

            return json_encode($data);
        }
    }

}
