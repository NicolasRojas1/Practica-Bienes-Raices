<?php

namespace App;

class ActiveRecord {
     //DB, static solo para que se cree una vez, no es necesario crear varias conexiones
     protected static $db;

     //Para el proceso de sanitizar, se crea un arreglo para identificar la forma de los datos
     protected static $columnasDB = [];

     // Para saber que tabla de la db se trabaja en la herencia
     protected static $tabla = '';
 
     //Errores para validar, static por que no se requiere instanciar
     protected static $errores = [];

     //Definir la conexion a la DB
     public static function setDB($database)
     {
         //self hace referencia a los atributos estaticos de una misma clase
         self::$db = $database;
     }
 
     public function guardar(){
         //Para actualizar el id no debe de estar nulo
         if (!is_null($this->id)) {
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
         $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ('$filas')";
         // debuguear($query);
 
         //Se pasa el query para ejecutarse en la db
         $resultado = self::$db->query($query);
 
         //Mensaje de exito
         if ($resultado) {
             // Redireccionar al usuario
             header('Location: /bienesraices/admin/index.php?resultado=1');
         }
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
         $query = " UPDATE " . static::$tabla . " SET ";
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
     //Eliminar un registro
     public function eliminar() {
         //Se escapa el id es por que se hace una consulta en la db y asi evito que inyecten codigo malicioso
         $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
         $resultado = self::$db->query($query);
 
         if ($resultado) {
             $this-> borrarImagen();
             header('Location: /bienesraices/admin/index.php?resultado=3');
         }
     }
     
     //Identifica y une los atributos de la DB a los ingresados
     public function atributos()
     {
         $atributos = [];
         foreach (static::$columnasDB as $columna) {
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
         // Elimina la imagen previa
         if( !is_null($this-> id) ) {   
 
             $this->borrarImagen();
         }
 
         //Asigna la nueva imagen
         if ($imagen) {
             $this->imagen = $imagen;
         }
     }
 
     // Eliminar el archivo
     public function borrarImagen() {
 
         //file_exists para comprobar si existe el archivo con la superglobal de CARPETA IMAGENES
         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen );
 
         //Con esto elimino la imagen
         if($existeArchivo) {  
             unlink(CARPETA_IMAGENES . $this->imagen);
           }
     }
 
     //Validacion
     public static function getErrores()
     {
        return static::$errores;
     }
 
     public function validar()
     {
        static::$errores = [];
        //Se retornan los errores al arreglo, static para que vaya al hijo
        return static::$errores;
     }
 
     // Listar todas las propiedades
     public static function all()
     {
         //Este query retorna un arreglo, static busca el atributo tabla de la clase que lo hereda
         $query = "SELECT * FROM ". static::$tabla;

         //Lo relacionado a la db utiliza la siguiente sintaxis
         $resultado = self::consultarSQL($query);
 
         //retorno el arreglo con los objetos mapeados
         return $resultado;
     }

     //Listar determinado numero de registros
     public static function get($cantidad)
     {
         //Este query retorna un arreglo, static busca el atributo tabla de la clase que lo hereda
         $query = "SELECT * FROM ". static::$tabla . " LIMIT " . $cantidad;
         //debuguear($query);

         //Lo relacionado a la db utiliza la siguiente sintaxis
         $resultado = self::consultarSQL($query);
 
         //retorno el arreglo con los objetos mapeados
         return $resultado;
     }
 
     // Busca una registro por su id
     public static function find($id)
     {
         $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
 
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
             $array[] = static::crearObjeto($registro);
         }
 
         // Liberar la memoria, para ayudar al servidor ya que se termino la consulta
         $resultado->free();
 
         // Retornar los resultados
         return $array;
     }
 
     //Toma un arreglo que es el resultado de la db y crea un objeto en memoria que es un espejo de lo que hay en la db
     protected static function crearObjeto($registro)
     {
         $objeto = new static(); //con new static crea un nuevo objeto en la clase que se esta heredando
 
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