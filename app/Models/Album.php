<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 17 Mar 2019 01:18:38 +0300.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Album
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $songs
 *
 * @package App\Models
 */
class Album extends Eloquent
{
	protected $fillable = [
		'name'
	];

	public function songs()
	{
		return $this->belongsToMany('\App\Models\Song', 'album_id');
	}
}
