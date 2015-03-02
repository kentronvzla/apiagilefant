<?php

class Story extends BaseModel {

    public $timestamps = false;
    protected $table = "stories";
    protected $primaryKey = "id";

    public function buscarActividadyTarea() {
        $etiquetas = $this->labels;
        foreach ($etiquetas as $etiqueta) {
            $arr = explode('-', $etiqueta->displayName);
            if (count($arr) == 2) {
                $this->ACTIVIDAD = $arr[0];
                $this->TAREA = $arr[1];
                break;
            }
        }
        if (is_numeric($this->ACTIVIDAD) && $this->TAREA != "") {
            $this->save();
            return true;
        }
        return false;
    }

    public function labels() {
        return $this->hasMany('Labels', 'story_id');
    }

    public function backlog() {
        return $this->belongsTo('Backlog', 'backlog_id');
    }
}
