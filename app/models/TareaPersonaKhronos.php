<?php

class TareaPersonaKhronos extends OracleBaseModel {

    public $timestamps = false;
    protected $table = "TAREAS_PERSONA";
    protected $primaryKey = "IDTAREA";
    protected $sequence = "SQ_IDTAREA";
    protected $rules = array(
        'IDTAREA' => 'integer',
        'CIPERS' => 'required',
        'FECTAREA' => 'required',
        'ANO' => 'required|integer',
        'SEMANA' => 'required|integer',
        'DESCTAREA' => 'required|max:80',
        'TIEMPO' => 'required',
        'CODTAREA' => 'required',
        'IDACT' => 'required',
        'IDOT' => 'required',
        'TBRUTO' => 'required',
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
            //con la actualizacion de yajra/oci8 se maneja la sequencia desde el modelo.
            //$tareaKhronos->IDTAREA = DB::connection('oracle')->nextSequenceValue('SQ_IDTAREA');
            $tareaKhronos->save();
            $trabajo->IDKHRONOS = $tareaKhronos->IDTAREA;
            $trabajo->SINCRONIZADA = true;
            $trabajo->save();
        }
        return $tareaKhronos;
    }

    public function validate($model = null) {
        if (parent::validate($model)) {
            //existe la cedula?.
            $count = DB::connection('oracle')->table('PERSONAS')->where('CIPERS', '=', $this->CIPERS)->count();
            if ($count == 0) {
                $this->errors->add('CIPERS', 'La cedula no esta registrada en khronos.');
            }
            //existe la tarea?.
            $count = DB::connection('oracle')->table('TAREAS')->where('CODTAREA', '=', $this->CODTAREA)->count();
            if ($count == 0) {
                $this->errors->add('CODTAREA', 'La tarea no esta registrada en khronos.');
            }
            //existe la tarea?.
            $count = DB::connection('oracle')->table('ACTS_OT')->where('IDACT', '=', $this->IDACT)->count();
            if ($count == 0) {
                $this->errors->add('IDACT', 'La actividad no esta registrada en khronos.');
            }
            //existe la ot?.
            $count = DB::connection('oracle')->table('ORDENES_TRABAJO')->where('IDOT', '=', $this->IDOT)->count();
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

    protected function getPrettyFields() {
        
    }

    protected function getPrettyName() {
        
    }
}
