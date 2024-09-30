<?php

namespace App;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
     //Para el proceso de sanitizar, se crea un arreglo para identificar la forma de los datos
     protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

     public $id;
     public $titulo;
     public $precio;
     public $imagen;
     public $descripcion;
     public $habitaciones;
     public $wc;
     public $estacionamiento;
     public $creado;
     public $vendedorId;

     public function __construct($args = [])
     {
         // ?? funcionan como placeholder cuando no se ingresa el valor
         $this->id = $args['id'] ?? NULL;
         $this->titulo = $args['titulo'] ?? '';
         $this->precio = $args['precio'] ?? '';
         $this->imagen = $args['imagen'] ?? '';
         $this->descripcion = $args['descripcion'] ?? '';
         $this->habitaciones = $args['habitaciones'] ?? '';
         $this->wc = $args['wc'] ?? '';
         $this->estacionamiento = $args['estacionamiento'] ?? '';
         $this->creado = date('Y/m/d');
         $this->vendedorId = $args['vendedorId'] ?? 1;
     }

     public function validar()
     {
         if (!$this->titulo) {
             self::$errores[] = "Debes añadir un titulo";
         }
 
         if (!$this->precio) {
             self::$errores[] = "Debes añadir un precio";
         }
 
         if (strlen($this->descripcion) < 50) {
             self::$errores[] = "Debes añadir una descripcion y debe tener al menos 50 caracteres";
         }
 
         if (!$this->habitaciones) {
             self::$errores[] = "El numero de habitaciones es obligatorio";
         }
 
         if (!$this->wc) {
             self::$errores[] = "El numero de baños es obligatorio";
         }
 
         if (!$this->estacionamiento) {
             self::$errores[] = "El numero de estacionamiento es obligatorio";
         }
 
         if (!$this->vendedorId) {
             self::$errores[] = "Elige un vendedor";
         }
 
         if (!$this->imagen) {
             self::$errores[] = "La imagen del inmueble es necesaria";
         }
 
         //Se retornan los errores al arreglo
         return self::$errores;
     }
}
