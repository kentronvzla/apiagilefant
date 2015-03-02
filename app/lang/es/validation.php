<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    "accepted" => "El/La :attribute debe ser aceptado.",
    "active_url" => "El/La :attribute no es un link valido.",
    "after" => "EL/La :attribute debe ser después de :date.",
    "alpha" => "El/La :attribute debe contener solamente letras.",
    "alpha_dash" => "El/La :attribute debe contener solamente letras, números, y guiones.",
    "alpha_num" => "El/La :attribute may only contain letters and numbers.",
    "array" => "El/La :attribute debe ser un arreglo.",
    "before" => "El/La :attribute debe ser antes de :date.",
    "between" => array(
        "numeric" => "El/La :attribute debe estar entre :min y :max.",
        "file" => "El/La :attribute debe estar entre :min y :max kilobytes.",
        "string" => "El/La :attribute debe tener entre :min y :max caracteres.",
        "array" => "El/La :attribute debe tener entre :min y :max elementos.",
    ),
    "confirmed" => "Las :attribute no coinciden.",
    "date" => "El/La :attribute no es una fecha válida.",
    "date_format" => "El/La :attribute no coincide con el formato :format.",
    "different" => "El/La :attribute y :other deben ser diferente.",
    "digits" => "El/La :attribute debe tener :digits dígitos.",
    "digits_between" => "El/La :attribute debe tener entre :min y :max dígitos.",
    "email" => "El formato :attribute es inválido.",
    "exists" => "El/La :attribute es inválido.",
    "image" => "El/La :attribute debe ser una imagen.",
    "in" => "El/La :attribute es inválido.",
    "integer" => "El/La :attribute debe ser un entero.",
    "ip" => "El/La :attribute debe ser una dirección IP válida.",
    "max" => array(
        "numeric" => "El/La :attribute no puede ser mayor a :max.",
        "file" => "El/La :attribute no puede ser mayor a :max kilobytes.",
        "string" => "El/La :attribute no puede ser mayor a :max caracteres.",
        "array" => "El/La :attribute no puede tener mas de :max elementos.",
    ),
    "mimes" => "El/La :attribute debe ser un archivo de tipo: :values.",
    "min" => array(
        "numeric" => "El/La :attribute debe ser al menos :min.",
        "file" => "El/La :attribute debe tener al menos :min kilobytes.",
        "string" => "El/La :attribute debe tener al menos :min caracteres.",
        "array" => "El/La :attribute debe tener al menos :min elementos.",
    ),
    "not_in" => "El/La :attribute seleccionado es inválido.",
    "numeric" => "El/La :attribute debe ser un número.",
    "regex" => "El formato :attribute es inválido.",
    "required" => "El campo :attribute  es necesario.",
    "required_if" => "El campo :attribute es necesario cuando :other es :value.",
    "required_with" => "El campo :attribute es necesario cuando :values está presente.",
    "required_with_all" => "El campo :attribute es necesario cuando :values están presentes.",
    "required_without" => "El campo :attribute es necesario cuando :values no está presente.",
    "required_without_all" => "El :attribute es necesario cuando :values no estan presentes.",
    "same" => "El/La :attribute y :other deben coincidir.",
    "size" => array(
        "numeric" => "El/La :attribute debe ser :size.",
        "file" => "El/La :attribute debe ser :size kilobytes.",
        "string" => "El/La :attribute debe ser :size caracteres.",
        "array" => "El/La :attribute debe contener :size elementos.",
    ),
    "unique" => "El/La :attribute ya ha sido elegido.",
    "url" => "El formato :attribute es inválido.",
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => array(),
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => array(),
);

