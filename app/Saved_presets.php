<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saved_presets extends Model {
	public function constraints() {
		return json_decode($this->preset);
	}
}
