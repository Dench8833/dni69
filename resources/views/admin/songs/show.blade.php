@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('song.show', $id) }}
    </div>
@stop

@section('content')
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
           <p>{{ $song }}</p>
           <div class="row text-center">Прикрепленные файлы</div>
           <div class="row">
               Фото: <img src="{{ asset($song->photo->path) }}" alt="" style="width:350px">
           </div>

           <div class="row">
               Трек: <br>

               <audio controls>
                   <source src="{{asset($song->path)}}" type="audio/mpeg">
                   Your browser does not support the audio element.
               </audio>
           </div>
       </div>

    </div>
@endsection
