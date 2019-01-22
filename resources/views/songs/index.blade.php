@extends('adminlte::page')

@section('content_header')
    <h1>Песни</h1>

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
                    <th scope="col">Короткое описание</th>
                    <th scope="col">Дата написания</th>
                    <th scope="col">Загружена</th>
                    <th scope="col">Обновлена</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Правда о ржевской битве (исп. Кобзон)</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Просмотр">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Редактирование">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Удаление">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@stop