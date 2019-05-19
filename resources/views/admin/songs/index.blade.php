@extends('admin.index')

@section('content_header')
    <div class="container-fluid">
        {{ Breadcrumbs::render('songs') }}
    </div>
@endsection

@section('content')
    @include('admin.flash-message')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                Размер загруженных файлов: <span class="total-files-size"><b>{{$fileSize}} MB</b></span>
            </div>
            <div class="col-md-3 text-right">
                <button type="button" class="btn btn-success">
                    <a href="{{route('song.create')}}">
                        <span style="color: white;" >Добавить песню</span>
                    </a>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название песни</th>
                    <th scope="col">Альбом</th>
                    <th scope="col">Размер (MB)</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Дата написания</th>
                    <th scope="col">Загружена</th>
                    <th scope="col">Обновлена</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($songs as $song)
                <tr>
                    <th scope="row">{{$song->getOriginal('id')}}</th>
                    <td>{{ $song->name }}</td>
                    <td>{{ $song->album->name }}</td>
                    <td>{{ round($song->size/1000000, 2) }}</td>
                    <td>{{ $song->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($song->created_at)->format('d.m.Y') }}</td>
                    <td>{{ $song->uploaded }}</td>
                    <td>{{ $song->updated_at }}</td>
                    <td style="min-width: 140px">
                        <a href="{{route('song.show', ['id' => $song->id])}}">
                            <button type="button" class="btn action btn-secondary" data-toggle="tooltip" data-placement="top" title="Просмотр">
                                <i class="fa fa-eye text-black" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{route('song.edit', ['id' => $song->id])}}">
                            <button type="button" class="btn action btn-success" data-toggle="tooltip" data-placement="top" title="Редактирование">
                                <i class="fa fa-pencil-square text-black" aria-hidden="true"></i>
                            </button>
                        </a>
                        <button type="button" class="btn action-delete btn-danger"
                                data-route="{{ route('song.delete', ['id' => $song->id]) }}"
                                data-toggle="tooltip" data-placement="top" title="Удаление">
                            <i class="fa fa-trash text-black" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

<script>
    window.onload = function() {
        $(document).ready(function () {
            $('.action-delete').on('click', function () {
                let massage = 'Вы действительно хотите удалить эту песню?';
                if (confirm(massage)) {
                    window.location.href = $('.action-delete').data('route');
                    return false;
                }
            });
        });
    };

</script>
