<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 17 Mar 2019 01:19:46 +0300.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Photo
 * 
 * @property int $id
 * @property string $path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $songs
 *
 * @package App\Models
 */
class Photo extends Eloquent
{
	protected $fillable = [
		'path', 'size'
	];

	public function songs()
	{
		return $this->belongsTo('\App\Models\Song', 'photo_id');
	}
}
