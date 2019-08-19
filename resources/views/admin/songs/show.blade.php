@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('song.show', $id) }}
    </div>
@stop

@section('content')

    <div class="text-right">
        <button type="button" class="btn btn-success">
            <a href="{{ url('admin/song/edit/'.$id) }}">
                <span style="color: white;">Редактировать</span>
            </a>
        </button>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row text-center">Основные данные</div>
            <table class="table table-bordered  table-hover">
                <tbody>
                @foreach($song->getOriginal() as $key => $val)
                    <tr>
                        <td class="col-md-1 text-right" style=" border: 1px solid #aaa !important">{{$key}}:</td>
                        <td style=" border: 1px solid #aaa !important">{{$val}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
       <div class="col-md-6">
           <div class="row text-center">Текст песни</div>
           <div class="row">
               {!! $song->lyric->text ?? '' !!}
           </div>
           <div class="row text-center">Прикрепленные файлы</div>
           <div class="row">
               Фото: <img src="{{ asset('storage/'.$song->photo->path) }}" alt="" style="width:350px">
           </div>

           <div class="row">
               Трек:
               <audio controls>
                   <source src="{{ asset('storage/'.$song->path) }}" type="audio/mpeg">
                   Your browser does not support the audio element.
               </audio>
           </div>
       </div>
    </div>
@endsection
