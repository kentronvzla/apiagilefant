<?php

/**
 * Description of BaseModel
 * Modelo base que extiende a eloquent con todo lo necesario para validaciones.
 * y observadores
 * 
 * Validaciones: Para poder usar la validacion se debe incluir los atributos protected $rules, y $messages para el validator.
 * Si se quiere validación especial se debe sobreescribir el metodo Validate.
 * Por defecto el metodo validate es ejecutado con el evento save();
 *
 * @author Nadin Yamaui
 */
abstract class BaseModel extends Eloquent {

    protected $rules = array();
    protected $primaryKey = "ID";
    protected $appends = array();
    protected $validar = true;

    /**
     * Tenemos una copia del objeto antes de actualizarlo.
     * @var type 
     */
    protected $objectAfterUpdate;

    /**
     * Error message bag
     * @var Illuminate\Support\MessageBag
     */
    public $errors;

    /**
     * Validator instance
     * @var Illuminate\Validation\Validators
     */
    protected $validator;

    /**
     * The database table used by the model.
     * @var string
     */
    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->validar = true;
        $this->errors = new \Illuminate\Support\MessageBag();
        $this->validator = \App::make('validator');
    }

    /**
     * Nos registramos para los listener de laravel
     * si un hijo desea usar uno debe sobreescribir el metodo.
     * Docs: http://laravel.com/docs/eloquent#model-events
     */
    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            return $model->creatingModel($model);
        });
        static::created(function($model) {
            return $model->createdModel($model);
        });
        static::updating(function($model) {
            return $model->updatingModel($model);
        });
        static::updated(function($model) {
            return $model->updatedModel($model);
        });
        static::saving(function($model) {
            return $model->savingModel($model);
        });
        static::saved(function($model) {
            return $model->savedModel($model);
        });
        static::deleting(function($model) {
            return $model->deletingModel($model);
        });
        static::deleted(function($model) {
            return $model->deletedModel($model);
        });
    }

    public static function create(array $attributes) {
        $model = new static();
        $model->fill($attributes);
        $model->save();
    }

    /**
     * Metodo que se ejecuta antes de crear un objeto
     * Si el retorno es false no se crea el modelo
     * Docs: http://laravel.com/docs/eloquent#model-events
     * @return boolean
     */
    public function creatingModel($model) {
        return true;
    }

    /**
     * Metodo que se ejecuta al crear un modelo. 
     * Si se sobre escribe se pierde la funcionalidad de auditar los procesos realizados contra la bd. 
     * Se debe incluir $this->auditarProceso('I');
     * Docs: http://laravel.com/docs/eloquent#model-events
     */
    public function createdModel($model) {
        
    }

    /**
     * Metodo que se ejecuta antes de actualizar un objeto. 
     * Si el retorno es false no se actualiza el modelo
     * Docs: http://laravel.com/docs/eloquent#model-events
     * @return boolean
     */
    public function updatingModel($model) {
        $this->objectAfterUpdate = self::find($model->{$model->primaryKey});
        return true;
    }

    /**
     * Metodo que se ejecuta luego de actualizar un objeto.
     * Si se sobre escribe se pierde la funcionalidad de auditar los procesos realizados contra la BD
     * Se debe incluir $this->auditarProceso('U',$model);
     * Docs: http://laravel.com/docs/eloquent#model-events
     */
    public function updatedModel($model) {
        
    }

    /**
     * Metodo que se ejecuta al ejecutar el metodo save del objeto
     * si retorna false no se guardan los cambios en la BD
     * Por defecto llama al metodo validate.
     * Docs: http://laravel.com/docs/eloquent#model-events
     * @return boolean
     */
    public function savingModel($model) {
        if ($this->validar) {
            return $this->validate($model);
        }
        return true;
    }

    /**
     * Metodo que se ejecuta al terminar de ejecutar el metodo save del objeto
     * Docs: http://laravel.com/docs/eloquent#model-events
     */
    public function savedModel($model) {
        
    }

    /**
     * Metodo que se ejecuta antes de eliminar un modelo de la bd
     * si retorna false no se elimina
     * Docs: http://laravel.com/docs/eloquent#model-events
     * @return boolean
     */
    public function deletingModel($model) {
        return true;
    }

    /**
     * Metodo que se ejecuta luego de eliminar un objeto de la bd.
     * Si se sobre escribe se pierde la funcionalidad de auditar los procesos realizados contra la BD
     * Se debe incluir $this->auditarProceso('D',$model);
     * Docs: http://laravel.com/docs/eloquent#model-events
     */
    public function deletedModel($model) {
        
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Set error message bag
     * 
     * @var Illuminate\Support\MessageBag
     */
    protected function setErrors($errors) {
        $this->errors = $errors;
    }

    public static function findOrNew($str, $columns = Array()) {
        if ($str == "") {
            return new static();
        } else {
            return static::find($str);
        }
    }

    /**
     * Validates current attributes against rules
     */
    public function validate() {
        $v = $this->validator->make($this->attributes, $this->rules);
        if ($v->passes()) {
            return true;
        }
        $this->setErrors($v->messages());
        return false;
    }

    public function getParsedErrors() {
        $retorno = "";
        foreach ($this->errors->all() as $error) {
            $retorno .= $error . "<br>";
        }
        return $retorno;
    }

    public static function getTag($tag, $search) {
        $matches = array();
        $pattern = "#<\s*?$tag\b[^>]*>(.*?)</$tag\b[^>]*>#s";
        preg_match($pattern, $search, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return "No encontrado";
        }
    }

    public function hasErrors() {
        return $this->errors->count() > 0;
    }
}
