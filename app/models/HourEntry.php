<?php

class HourEntry extends BaseModel {

    public $timestamps = false;
    protected $table = "hourentries";
    protected $primaryKey = "id";

    public function task() {
        return $this->belongsTo('Task', 'task_id');
    }
    
    public function story() {
        return $this->belongsTo('Story', 'story_id');
    }

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

    public function khronos(){
        return $this->belongsTo('TareaPersonaKhronos', 'IDKHRONOS');
    }
}
