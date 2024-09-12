<?php

namespace App;

class Propiedad {

    //DB, static solo para que se cree una vez, no es necesario crear varias conexiones
    protected static $db;
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

    //Definir la conexion a la DB
    public static function setDB($database) {
        //self hace referencia a los atributos estaticos de una misma clase
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        // ?? funcionan como placeholder cuando no se ingresa el valor
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar() {

        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();
        debuguear($atributos);

        //Insertar en la db
        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) VALUES ( '$this->titulo', '$this->precio', '$this->imagen', '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedorId' ) ";

        $resultado = self::$db-> query($query);

        debuguear($resultado);
    }

    //Identifica y une los atributos de la DB a los ingresados
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            //Para que igner el id, ya que la db lo agrega automaticamente
            if($columna === 'id') continue; 
            //Se van mapeando los atributos con las columnas de la db
            $atributos[$columna] = $this-> $columna;
        }
        return $atributos;
    }

    //Sanitiza cada atributo, para evitar codigo malicioso en la app
    public function sanitizarAtributos() {
        //Llamo al metodo que mapea las columnas con el objeto en memoria que se tiene
        $atributos = $this-> atributos();
        $sanitizado = [];

        //Asi tomo tanto el nombre del atributo y el valor que se ingresa, ej: 'titulo' como key, 'casa en las montañas' como value
        foreach($atributos as $key => $value) {
            //Con escape_string sanitizo los datos del value, que son los que me interesan guardar en la db
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }
    
}