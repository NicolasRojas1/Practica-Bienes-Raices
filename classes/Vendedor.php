<?php

namespace App;

class Vendedor extends ActiveRecord {

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
}