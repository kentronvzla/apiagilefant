<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SincronizadorController
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class SincronizadorController extends BaseController {

    public function sincronizar($id) {
        $trabajos = HourEntry::where('SINCRONIZADA', '=', 0)->where('user_id', '=', $id)->get();
        $data['cantidad'] = count($trabajos);
        $data['infotrabajo'] = array();
        $data['infoactividadtarea'] = array();
        $data['infobacklog'] = array();
        $data['infokhronos'] = array();
        $data['erroractividadtarea'] = array();
        $data['errorbacklog'] = array();
        $data['errorkhronos'] = array();
        $data['errorgrave'] = array();
        $data['hayError'] = false;
        foreach ($trabajos as $trabajo) {
            $correcto = true;
            $data['infotrabajo'][] = "Cargando trabajo: " . $trabajo->id;
            if ($trabajo->task_id == null) {
                $data['errorgrave'][] = "El registro de tiempo ".$trabajo->id." "
                        . "esta cargado directamente a la HU: ".$trabajo->story->name.", Se debe cargar a la tarea.";
            } else {
                if ($trabajo->task->story->ACTIVIDAD == null) {
                    $data['infoactividadtarea'][] = "Buscando actividad y tarea de la historia: " . $trabajo->task->story->name . '->' . $trabajo->task->story->id;
                    if (!$trabajo->task->story->buscarActividadyTarea()) {
                        $data['erroractividadtarea'][] = "No se pudo buscar la actividad o la tarea. de la historia : " . $trabajo->task->story->id;
                        $correcto = false;
                        $data['hayError'] = true;
                    }
                }
                if ($trabajo->task->story->backlog->OT == null) {
                    $data['infobacklog'][] = "Buscando ot del backlog :" . $trabajo->task->story->backlog->name . '->' . $trabajo->task->story->backlog->id;
                    if (!$trabajo->task->story->backlog->buscarOt()) {
                        $data['errorbacklog'][] = "No se pudo buscar la ot. :(";
                        $correcto = false;
                        $data['hayError'] = true;
                    }
                }
                if ($correcto) {
                    $data['infokhronos'][] = "Sincronizando trabajo con khronos." . $trabajo->id;
                    $tareaPersona = TareaPersonaKhronos::crear($trabajo);
                    if (!$tareaPersona->hasErrors()) {
                        $data['infokhronos'][] = "Se creó la tarea en khronos correctamente";
                    } else {
                        $data['errorkhronos'][] = $tareaPersona->getParsedErrors();
                        $data['hayError'] = true;
                    }
                } else {
                    $data['errorkhronos'][] = "No se puede cargar el trabajo: " . $trabajo->id . " hace falta mas información.";
                }
            }
        }
        return View::make('index', $data);
    }

}
