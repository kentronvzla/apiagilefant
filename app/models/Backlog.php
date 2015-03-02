<?php

class Backlog extends BaseModel {

    public $timestamps = false;
    protected $table = "backlogs";
    protected $primaryKey = "id";

    public function buscarOt() {
        $this->OT = static::getTag('ot', $this->name);
        if(is_numeric($this->OT)){
            $this->save();
            return true;
        }
        return false;
    }

    protected function getPrettyFields() {
        
    }

    protected function getPrettyName() {
        
    }

}
