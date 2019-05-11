<div class="row">
    <div class="col-md-6">
        <div class="form-check">
            <label class="song_show" for="exampleCheck1">Отображать на сайте:</label>
            <input type="checkbox" class="form-check-input" name="show" checked>
        </div>
        <div class="form-group">
            <label for="name">Название песни:</label>
            <input type="text" class="form-control" name="name"
                   value="{{ old('name')?? $song->name ?? '' }}"/>
        </div>
        <div class="form-group">
            <label for="album">Название альбома:</label><br>
            <select id="album_select" class="form-control" name="album">
            @foreach($albums as $album)
                <option value="{{ $album->id }}">{{ $album->name }}</option>
            @endforeach
        </select>
        </div>
        <div class="form-group">
            <label for="date">Дата написания:</label>
            <input type="date" class="form-control" name="date"
                   value="{{ old('date') ?? \Illuminate\Support\Carbon::today()->format('d.m.Y') }}"/>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" name="description"
                      rows="4">{{ old('description') ?? $song->description ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="photo">Прикрепить фото:</label>
            <input type="file" class="form-control" name="photo" value="{{ old('photo') ?? $song->photo ?? '' }}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="lyrics">Текст песни:</label>
            <textarea type="text" class="form-control" name="lyrics" rows="15">{{ old('lyrics') ?? $song->lyric->text ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="song">Загрузить песню:</label>
            <input id="song" type="file" class="form-control" name="song" value="{{ old('song') ?? $song->file ?? '' }}"/>
        </div>
    </div>
</div>
<div class="row text-center">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
{{ \Illuminate\Support\Carbon::today()->format('d.m.Y') }}
