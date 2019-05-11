<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 17 Mar 2019 01:19:53 +0300.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Song
 * 
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $size
 * @property int $album_id
 * @property int $photo_id
 * @property int $lyrics_id
 * @property string $description
 * @property \Carbon\Carbon $uploaded
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted
 * 
 * @property \App\Models\Album $album
 * @property \App\Models\Lyric $lyric
 * @property \App\Models\Photo $photo
 *
 * @package App\Models
 */
class Song extends Eloquent
{
	protected $casts = [
		'size' => 'int',
		'album_id' => 'int',
		'photo_id' => 'int',
		'lyric_id' => 'int'
	];

	protected $dates = [
		'uploaded',
		'deleted'
	];

	protected $fillable = [
		'name',
		'path',
		'size',
		'album_id',
		'photo_id',
		'lyric_id',
		'description',
		'uploaded',
		'deleted'
	];

	public function album()
	{
		return $this->hasOne('\App\Models\Album', 'id', 'album_id');
	}

	public function lyric()
	{
		return $this->hasOne('\App\Models\Lyric', 'id', 'lyric_id');
	}

	public function photo()
	{
		return $this->hasOne('\App\Models\Photo', 'id', 'photo_id');
	}
}
