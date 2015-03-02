<?php

class TareaPersonaKhronos extends OracleBaseModel {

    public $timestamps = false;
    protected $table = "TAREAS_PERSONA";
    protected $primaryKey = "idtarea";
    protected $sequence = "SQ_IDTAREA";
    protected $rules = array(
        'idtarea' => 'integer',
        'cipers' => 'required',
        'fectarea' => 'required',
        'ano' => 'required|integer',
        'semana' => 'required|integer',
        'desctarea' => 'required|max:80',
        'tiempo' => 'required',
        'codtarea' => 'required',
        'idact' => 'required',
        'idot' => 'required',
        'tbruto' => 'required',
    );

    public static function crear(HourEntry $trabajo) {
        $tareaKhronos = new TareaPersonaKhronos();
        $fecTarea = new Carbon($trabajo->date);
        $tareaKhronos->CIPERS = $trabajo->user->cedula;
        $tareaKhronos->FECTAREA = $fecTarea->format('Y-m-d');
        $tareaKhronos->ANO = $fecTarea->format('Y');
        $tareaKhronos->SEMANA = (int)$fecTarea->format('W');
        $tareaKhronos->DESCTAREA = $trabajo->description;
        $horas = floor($trabajo->minutesSpent / 60);
        if ($horas < 10) {
            $horas = "0" . $horas;
        }
        $minutos = $trabajo->minutesSpent % 60;
        if ($minutos < 10) {
            $minutos = "0" . $minutos;
        }
        $tareaKhronos->TIEMPO = $horas . ':' . $minutos;
        $tareaKhronos->CODTAREA = $trabajo->task->story->TAREA;
        $tareaKhronos->IDACT = $trabajo->task->story->ACTIVIDAD;
        $tareaKhronos->IDOT = $trabajo->task->story->backlog->OT;
        $tareaKhronos->TBRUTO = 0;
        if ($tareaKhronos->validate()) {
            $tareaKhronos->save();
            $trabajo->IDKHRONOS = $tareaKhronos->IDTAREA;
            $trabajo->SINCRONIZADA = true;
            $trabajo->save();
        }
        return $tareaKhronos;
    }

    public function validate() {
        if (parent::validate()) {
            //existe la cedula?.
            $count = DB::connection('oracle')->table('PERSONAS')->where('CIPERS', '=', $this->cipers)->count();
            if ($count == 0) {
                $this->errors->add('CIPERS', 'La cedula no esta registrada en khronos.');
            }
            //existe la tarea?.
            $count = DB::connection('oracle')->table('TAREAS')->where('CODTAREA', '=', $this->codtarea)->count();
            if ($count == 0) {
                $this->errors->add('CODTAREA', 'La tarea no esta registrada en khronos.');
            }
            //existe la tarea?.
            $count = DB::connection('oracle')->table('ACTS_OT')->where('IDACT', '=', $this->idact)->count();
            if ($count == 0) {
                $this->errors->add('IDACT', 'La actividad no esta registrada en khronos.');
            }
            //existe la ot?.
            $count = DB::connection('oracle')->table('ORDENES_TRABAJO')->where('IDOT', '=', $this->idot)->count();
            if ($count == 0) {
                $this->errors->add('IDOT', 'La ot no esta registrada en khronos.');
            }
            if ($this->hasErrors()) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function actualizar($trabajo){
        $fecTarea = new Carbon($trabajo->date);
        $this->fectarea = $fecTarea->format('Y-m-d');
        $this->ano = $fecTarea->format('Y');
        $this->semana = (int)$fecTarea->format('W');
        $this->desctarea = $trabajo->description;
        $horas = floor($trabajo->minutesSpent / 60);
        if ($horas < 10) {
            $horas = "0" . $horas;
        }
        $minutos = $trabajo->minutesSpent % 60;
        if ($minutos < 10) {
            $minutos = "0" . $minutos;
        }
        $this->tiempo = $horas . ':' . $minutos;
        $this->tbruto = 0;
        if ($this->save()) {
            $trabajo->MODIFICADA = 0;
            $trabajo->SINCRONIZADA = 1;
            $trabajo->save();
            return true;
        }
        return false;
    }

    public function hourEntry(){
        return $this->hasOne('HourEntry','IDKHRONOS');
    }
}
