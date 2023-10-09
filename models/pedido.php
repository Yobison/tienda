<?php
class Pedido{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    function getId(){
        return $this->id;
    }
    function getUsuario_id(){
        return $this->usuario_id;
    }
    function getProvincia(){
        return $this->provincia;
    }
    function getLocalidad(){
        return $this->localidad;
    }
    function getDireccion(){
        return $this->direccion;
    }
    function getCoste(){
        return $this->coste;
    }
    function getEstado(){
        return $this->estado;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getHora(){
        return $this->hora;
    }

    function setId($id){
        $this->id = $id;
    }
    
    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    function setProvincia($provincia){
        $this->provincia = $this->db->real_escape_string($provincia);
    }

    function setLocalidad($localidad){
        $this->localidad = $this->db->real_escape_string($localidad);
    }

    function setDireccion($direccion){
        $this->direccion = $this->db->real_escape_string($direccion);
    }

    function setCoste($coste){
        $this->coste = $this->db->real_escape_string($coste);
    }

    function setEstado($estado){
        $this->estado = $this->db->real_escape_string($estado);
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function setHora($hora){
        $this->hora = $hora;
    }

    public function getAll(){
        /*$productos= $this->db->query("SELECT *  FROM productos ORDER BY id DESC");
        return $productos;*/
        // Preparar una consulta SQL parametrizada
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
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
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
          
          $id = $this->getId();
          $stmt->bind_param("i", $id);

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

    public function getOneByUser (){
      /*$sql = "SELECT p.id, p.coste  FROM pedidos p "
        //. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
        . "WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
      $pedido= $this->db->query($sql);
      return $pedido->fetch_object(); */
      $usuario_id = $this->getUsuario_id();
      $sql = "SELECT p.id, p.coste FROM pedidos p WHERE p.usuario_id = ? ORDER BY id DESC LIMIT 1";
      $stmt = $this->db->prepare($sql);

      if ($stmt) {

        $stmt->bind_param("i", $usuario_id);

        $stmt->execute();

        $pedido = $stmt->get_result()->fetch_object();

        $stmt->close();

        return $pedido;
      }
    }

    public function getAllByUser (){
      /*$sql = "SELECT p.*  FROM pedidos p "
        //. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
        . "WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC";
      $pedido= $this->db->query($sql);
      return $pedido; */
      $usuario_id = $this->getUsuario_id();

      $sql = "SELECT p.* FROM pedidos p WHERE p.usuario_id = ? ORDER BY id DESC";
      $stmt = $this->db->prepare($sql);

      if ($stmt) {

        $stmt->bind_param("i", $usuario_id);

        $stmt->execute();

        $pedidos = $stmt->get_result();

        $stmt->close();

        return $pedidos;
      }
    }

    public function getProductosByPedido($id){
      /*/$sql = "SELECT * FROM productos WHERE id IN (SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
      $sql = "SELECT pr.*, lp.unidades FROM productos pr "
        . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
        . "WHERE lp.pedido_id = {$id}";
      $productos= $this->db->query($sql);
      return $productos;*/

      $sql = "SELECT pr.*, lp.unidades FROM productos pr "
        . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
        . "WHERE lp.pedido_id = ?";
      $stmt = $this->db->prepare($sql);

    
      if ($stmt) {

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $productos = $stmt->get_result();

        $stmt->close();

        return $productos;
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
    $usuario_id = $this->getUsuario_id();
    $provincia = $this->getProvincia();
    $localidad = $this->getLocalidad();
    $direccion = $this->getDireccion();
    $coste = $this->getCoste();
    //$estado = $this->getEstado();

    $sql = "INSERT INTO pedidos VALUES(NULL, ?, ?, ?, ?, ?, 'confirm', CURDATE(), CURTIME())";
    $stmt = $this->db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssd", $usuario_id, $provincia, $localidad, $direccion, $coste);

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

    public function save_linea(){
      /*$sql = "SELECT LAST_INSERT_ID() as 'pedido';";
      $query = $this->db->query($sql);
      $pedido_id = $query->fetch_object()->pedido;

      foreach($_SESSION['carrito'] as $elemento){
        $producto = $elemento['producto'];

        $insert = "INSERT INTO lineas_pedidos VALUES (NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
        $save = $this->db->query($insert);
      }
      $result = false;
      if($save){
          $result = true;
      }*/
      $sql = "SELECT LAST_INSERT_ID() as pedido";
      $query = $this->db->query($sql);
      $pedido_id = $query->fetch_object()->pedido;

      foreach($_SESSION['carrito'] as $elemento){
        $producto = $elemento['producto'];
        $unidades = $elemento['unidades'];

        $insert = "INSERT INTO lineas_pedidos VALUES (NULL, ?, ?, ?)";
        $stmt = $this->db->prepare($insert);

        if ($stmt) {
            $stmt->bind_param("iii", $pedido_id, $producto->id, $unidades);

            $save = $stmt->execute();

            if ($save) {
                $result = true;
            } else {
                $result = false;
            }

            $stmt->close();
        } else {
            $result = false;
        }
      }

      return $result;
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

    public function edit(){
      /*$sql = "UPDATE pedidos SET estado={$this->getEstado()}";
      
      $sql.= " WHERE id={$this->getId()};";

      $save = $this->db->query($sql);

      $result = false;
      if($save){
          $result = true;
      }
      return $result;*/

      $sql = "UPDATE pedidos SET estado=? WHERE id=?";
      
      $stmt = $this->db->prepare($sql);

      if ($stmt){
        $estado = $this->getEstado();
        $id = $this->getId();

        $stmt->bind_param("si", $estado, $id);
        $result = $stmt->execute();

        if ($result !== false) {
          return true;
        } else {
          return false;
        }
      }
    }

}