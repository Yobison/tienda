<?php
class Producto{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    function getId(){
        return $this->id;
    }
    function getCategoria_id(){
        return $this->categoria_id;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getDescripcion(){
        return $this->descripcion;
    }
    function getPrecio(){
        return $this->precio;
    }
    function getStock(){
        return $this->stock;
    }
    function getOferta(){
        return $this->oferta;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getImagen(){
        return $this->imagen;
    }

    function setId($id){
        $this->id = $id;
    }
    
    function setCategoria_id($categoria_id){
        $this->categoria_id = $categoria_id;
    }

    function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    function setDescripcion($descripcion){
        $this->descripcion = $this->db->real_escape_string($descripcion);
    }

    function setPrecio($precio){
        $this->precio = $this->db->real_escape_string($precio);
    }

    function setStock($stock){
        $this->stock = $this->db->real_escape_string($stock);
    }

    function setOferta($oferta){
        $this->oferta = $this->db->real_escape_string($oferta);
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function getAll(){
        /*$productos= $this->db->query("SELECT *  FROM productos ORDER BY id DESC");
        return $productos;*/
        // Preparar una consulta SQL parametrizada
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
          // Ejecutar la consulta
          $stmt->execute();

          // Obtener el resultado de la consulta
          $productos = $stmt->get_result();

          return $productos;
        } else {
          // Manejar errores de preparación de la consulta aquí
          echo "Error al preparar la consulta.";
          return null;
        }
    }

    public function getOne(){
        /*$producto= $this->db->query("SELECT *  FROM productos WHERE id={$this->getId()}");
        return $producto->fetch_object();*/
        // Preparar una consulta SQL parametrizada
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
          
          $stmt->bind_param("i", $this->getId()); 

          // Ejecutar la consulta
          $stmt->execute();

          // Obtener el resultado de la consulta
          $producto = $stmt->get_result()->fetch_object();

          return $producto;
        } else {
          // Manejar errores de preparación de la consulta aquí
          echo "Error al preparar la consulta.";
          return null;
        }
    }

    public function save(){
      /*$sql = "INSERT INTO productos VALUES(NULL, '{$this->getCategoria_id()}', '{$this->getNombre()}', '{$this->getDescripcion()}', '{$this->getPrecio()}', '{$this->getStock()}', null, CURDATE(), '{$this->getImagen()}');";
      $save = $this->db->query($sql);

      $result = false;
      if($save){
          $result = true;
      }
      return $result;*/
    $categoria_id = $this->getCategoria_id();
    $nombre = $this->getNombre();
    $descripcion = $this->getDescripcion();
    $precio = $this->getPrecio();
    $stock = $this->getStock();
    $imagen = $this->getImagen();

    $sql = "INSERT INTO productos VALUES(NULL, ?, ?, ?, ?, ?, null, CURDATE(), ?)";
    $stmt = $this->db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssds", $categoria_id, $nombre, $descripcion, $precio, $stock, $imagen);

        if ($stmt->execute()) {
            return true;
        } else {
            // Manejar errores aquí, por ejemplo, registrarlos o devolver un mensaje de error.
            return false;
        }
    } else {
        // Manejar errores de preparación de la consulta aquí.
        return false;
    }
  }



    public function edit(){
      /*$sql = "UPDATE productos SET nombre={$this->getNombre()}, descripcion={$this->getDescripcion()}, precio={$this->getPrecio()}, stock={$this->getStock()},categoria_id={$this->getCategoria_id()} ";
      
      if($this->getImagen() != null){
        $sql.= ", imagen='{$this->getImagen()}'";
      }
      
      $sql.= " WHERE id={$this->id};";

      $save = $this->db->query($sql);

      $result = false;
      if($save){
          $result = true;
      }
      return $result;*/

      $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?";
      
      $params = [$this->getNombre(), $this->getDescripcion(), $this->getPrecio(), $this->getStock(), $this->getCategoria_id()];

      if($this->getImagen() != null){
          $sql .= ", imagen=?";
          $params[] = $this->getImagen();
      }
      
      $sql .= " WHERE id=?";
      $params[] = $this->id;

      $stmt = $this->db->prepare($sql);

      if ($stmt) {
          $result = $stmt->execute($params);
          return $result !== false;
      } else {
          return false;
      }


    }

    public function delete(){
      /*$sql = "DELETE FROM productos WHERE id={$this->id}";
      $delete = $this->db->query($sql);*/
      $sql = "DELETE FROM productos WHERE id = ?";
    
      $stmt = $this->db->prepare($sql);
      if ($stmt) {
        $stmt->bind_param("i", $this->id);
        if ($stmt->execute()) {
            // La eliminación se realizó con éxito
            return true;
        }
      }
    
      // Si llegamos aquí, la eliminación falló
      return false;
    }

}