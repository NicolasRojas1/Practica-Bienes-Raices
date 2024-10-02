<?php

namespace App;

class Vendedor extends ActiveRecord
{

    protected static $tabla = 'vendedores';
    //Para el proceso de sanitizar, se crea un arreglo para identificar la forma de los datos
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        // ?? funcionan como placeholder cuando no se ingresa el valor
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }

        if (!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
        }

        if (!$this->telefono) {
            self::$errores[] = "El teléfono es obligatorio";
        }
        //Expresion regular para el teléfono
        if(!preg_match(('/[0-9]{10}/'), $this->telefono)) {
            self::$errores[] = 'Formato no válido';
        }

        //Retorno los errores
        return self::$errores;
    }
}
