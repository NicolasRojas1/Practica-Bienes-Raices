<?php

namespace App;

class Propiedad
{

    //DB, static solo para que se cree una vez, no es necesario crear varias conexiones
    protected static $db;

    //Para el proceso de sanitizar, se crea un arreglo para identificar la forma de los datos
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    //Errores para validar, static por que no se requiere instanciar
    protected static $errores = [];

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
    public static function setDB($database)
    {
        //self hace referencia a los atributos estaticos de una misma clase
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        // ?? funcionan como placeholder cuando no se ingresa el valor
        $this->id = $args['id'] ?? '';
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

    public function guardar() {
        if (isset($this->id)) {
            // Actualizo
            $this->actualizar();
        }else {
            // Creo un nuevo registro
            $this->crear();
        }
    }

    public function crear()
    {
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();

        //Llamar los datos de forma dinamica
        $columnas = join(', ', array_keys($atributos));
        $filas = join("', '", array_values($atributos));

        //*  Consulta para insertar datos
        $query = "INSERT INTO propiedades($columnas) VALUES ('$filas')";
        // debuguear($query);

        //Se pasa el query para ejecutarse en la db
        $resultado = self::$db->query($query);

        //debuguear($resultado);
        return $resultado;
    }

    public function actualizar() {
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        //Recorremos los elementos tanto llave como valor
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";    
        }
        //Generando la consulta de actualizar registro
        $query = " UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        //Redirecciono
        if ($resultado) {
            // Redireccionar al usuario, solo funciona si no hay nada de HTML previo
            header('Location: /bienesraices/admin/index.php?resultado=2');
        }
    }
    
    //Identifica y une los atributos de la DB a los ingresados
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            //Para que igner el id, ya que la db lo agrega automaticamente
            if ($columna === 'id')
                continue;
            //Se van mapeando los atributos con las columnas de la db
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Sanitiza cada atributo, para evitar codigo malicioso en la app
    public function sanitizarAtributos()
    {
        //Llamo al metodo que mapea las columnas con el objeto en memoria que se tiene
        $atributos = $this->atributos();
        $sanitizado = [];

        //Asi tomo tanto el nombre del atributo y el valor que se ingresa, ej: 'titulo' como key, 'casa en las montañas' como value
        foreach ($atributos as $key => $value) {
            //Con escape_string sanitizo los datos del value, que son los que me interesan guardar en la db
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Subida de imagenes
    public function setImagen($imagen)
    {
        //Comprobar si existe el archivo, isset revisa que exista y que tenga un valor
        if(isset($this-> id)) {
            //file_exists para comprobar si existe el archivo con la superglobal de CARPETA IMAGENES
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen );

            //Con esto elimino la imagen
            if($existeArchivo) {  
                unlink(CARPETA_IMAGENES . $imagen);
              }
        }

        //Asignar en el atributo imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Validacion
    public static function getErrores()
    {
        return self::$errores;
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

    // Listar todas las propiedades
    public static function all()
    {
        //Este query retorna un arreglo
        $query = "SELECT * FROM propiedades";
        //Lo relacionado a la db utiliza la siguiente sintaxis
        $resultado = self::consultarSQL($query);

        //retorno el arreglo con los objetos mapeados
        return $resultado;
    }

    // Busca una registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM propiedades WHERE id = {$id}";

        //para que traiga no un arreglo sino que un objeto
        $resultado = self::consultarSQL($query);

        //array shift sirve para retornar el primer resultado de un arreglo
        return array_shift($resultado);
    }

    // Metodo reutilizable para otros metodos, que consultara la db
    public static function consultarSQL($query)
    {
        // Consultar db
        $resultado = self::$db->query($query);

        // iterar resultados
        $array = [];
        // Traera un arreglo asociativo que llama otro metodo que lo convierte en objeto
        while ($registro = $resultado->fetch_assoc()) {
            // retorna los objetos y los agrega a un arreglo para mostrar en el index
            $array[] = self::crearObjeto($registro);
        }

        // Liberar la memoria, para ayudar al servidor ya que se termino la consulta
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    //Toma un arreglo que es el resultado de la db y crea un objeto en memoria que es un espejo de lo que hay en la db
    protected static function crearObjeto($registro)
    {
        $objeto = new self(); //con new self, estamos diciendo nueva propiedad

        foreach ($registro as $key => $value) {

            //verificar que una propiedad exista, mientras mapea los datos de arreglo hacia objetos que quedan unicamente en memoria
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    //Toma un arreglo vacio
    public function sincronizar($args = [])
    {
        //Se recorre el arreglo de tipo POST para ir asignando sus valores
        foreach ($args as $key => $value) {
            //con this se refiere a la propiedad
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
