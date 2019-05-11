@extends('adminlte::page')

@section('content')
    <!-- Modal -->
    @include('admin.albums.modal')
    <div class="row">
        <div class="col-md-8">
            <div class="col-md-3">
                <button type="button" class="btn btn-success add">
                    <span style="color: white;" >Добавить альбом</span>
                </button>
            </div>
            <table id="album-table" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Название альбома</th>
                    <th scope="col">Создан</th>
                    <th scope="col">Изменен</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($albums as $album)
                    <tr id="{{ $album->id }}">
                        <td class="album-name">{{ $album->name }}</td>
                        <td class="album-created_at">{{ $album->created_at }}</td>
                        <td class="album-updated_at">{{ $album->updated_at }}</td>
                        <td style="min-width: 140px">
                            <a type="button" href="#" class="btn btn-success update" data-toggle="tooltip"
                               data-placement="top" title="Сохранить" style="display: none;">
                                <i class="fa fa-save text-black" aria-hidden="true"></i>
                            </a>
                            <a type="button" href="#" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" title="Редактировать">
                                <i class="fa fa-pencil-square text-black" aria-hidden="true"></i>
                            </a>
                            <a type="button" href="#" class="btn btn-danger delete" data-toggle="modal" data-target="#albumModal" data-placement="top" title="Удалить">
                                <i class="fa fa-trash text-black" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    window.onload = function() {
        $(document).ready(function () {
            var id;
            var row;
            var inpVal;
            $('.add').on('click', function () {
                $('#album-table>tbody').append(
                    '<tr class ="new-row"><td class="album-name"><input class="inp" type="text"/></td>' +
                    '<td class="album-created_at"></td><td class="album-updated_at"></td><td style="min-width: 140px">' +
                    '<a type="button" href="#" class="btn btn-success save" data-toggle="tooltip" data-placement="top" title="Сохранить">' +
                    '<i class="fa fa-save text-black" aria-hidden="true"></i></a>' +
                    '<a type="button" href="#" class="btn btn-primary edit" data-toggle="tooltip" data-placement="top" title="Редактировать" style="display: none;">' +
                    '<i class="fa fa-pencil-square text-black" aria-hidden="true"></i></a>' +
                    '<a type="button" href="#" class="btn btn-danger delete" data-toggle="modal" data-target="#albumModal"  data-placement="top" title="Удалить">' +
                    '<i class="fa fa-trash text-black" aria-hidden="true"></i></a></td></tr>'
                );
                $(this).attr('disabled', 'disabled')
            });

            $('#album-table>tbody').on('click', '.btn', function () {
                if ($(this).hasClass('edit')) {
                    let tr = $(this).closest('tr');
                    let td = tr.find("td").first();
                    let tdText = td.text();
                    tr.find('.edit').hide();
                    tr.find('.update').show();
                    tr.find('.save').show();
                    td.append('<input class="inp" type="text" value="' + tdText + '"/>');
                    td.contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    $('table').find('.error-content').remove();
                }
                if ($(this).hasClass('update')) {
                    let tr = $(this).closest('tr');
                    let td = tr.find("td").first();
                    tr.find('.edit').show();
                    tr.find('.update').hide();
                    tr.find('.save').hide();
                    let id = $(this).closest('tr').attr('id');
                    let inp = $(this).closest('tr').find("input").first();
                    let inpVal = inp.val();
                    inp.hide();
                    td.text(inpVal);
                    sendAjax('update', inpVal, id);
                }
                if ($(this).hasClass('save')) {
                    let td = $(this).closest('tr').find("td").first();
                    $('.edit').show();
                    $('.save').hide();
                    let inp = $(this).closest('tr').find("input").first();
                    let inpVal = inp.val();
                    inp.hide();
                    td.text(inpVal);
                    sendAjax('save', inpVal);
                    $(this).removeClass('save').addClass('update');
                    $('.add').removeAttr('disabled');
                }
                if ($(this).hasClass('delete')) {
                    let row = $(this).closest('tr');
                    let inp = $(this).closest('tr').find("input").first();
                    inpVal = inp.val();
                    if (row.hasClass('new-row')) {
                        row.attr('id', 'album-new_row');
                        id = row.attr('id');
                    } else {
                        id = row.attr('id');
                    }
                }
            });

            $('body').on('click', '#del-album', function () {
                if (id !== 'album-new_row') {
                    sendAjax('delete', inpVal, id);
                }
                $('#' + id).remove();
                $('.add').removeAttr('disabled');
            });

            function sendAjax(action, name, id) {
                $.ajax({
                   data: {_token: '{{csrf_token()}}', action:action, name:name, id:id},
                    url: "{{ route('albums_crud') }}",
                    type: "POST",
                    success: function (data) {

                        var album = $.parseJSON(data);

                        if (album.action === 'save') {
                            let tr = $('table').find('.new-row');
                            tr.find('.album-name').text(album.name);
                            tr.find('.album-created_at').text(album.created_at);
                            tr.find('.album-updated_at').text(album.updated_at);
                            tr.attr('class', 'old');
                            tr.attr('id', album.id);
                        }

                        if (album.action === 'update') {
                            console.log('qwdqwdqwd');
                            let tr = $('table').find('#' + album.id);
                            tr.find('.album-name').text(album.name);
                            tr.find('.album-created_at').text(album.created_at);
                            tr.find('.album-updated_at').text(album.updated_at);
                        }

                    }, error: function (data) {
                        $('table').append('<p class="error-content">'+data.responseJSON.errors.name+'</p>');
                    }
                });
            }
        });
    }
</script>