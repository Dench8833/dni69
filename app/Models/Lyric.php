<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 17 Mar 2019 01:17:20 +0300.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Lyric
 * 
 * @property int $id
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $songs
 *
 * @package App\Models
 */
class Lyric extends Eloquent
{

	protected $fillable = [
		'text'
	];

	public function songs()
	{
		return $this->belongsTo('\App\Models\Song', 'lyrics_id');
	}
}
