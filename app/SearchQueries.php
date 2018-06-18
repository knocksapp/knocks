<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchQueries extends Model {
	public function init($object) {
		$this->keywords = $object->keywords;
		$this->query_id = $object->query_id;
		$this->query_type = $object->query_type;
		$this->child_id = $object->child_id;
		$this->object_quick_presets = $object->object_quick_presets;
		$this->save();
	}

}
