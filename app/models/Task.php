<?php

class Task extends BaseModel {

    public $timestamps = false;
    protected $table = "tasks";
    protected $primaryKey = "id";

    public function story() {
        return $this->belongsTo('Story', 'story_id');
    }
}
