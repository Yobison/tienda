<?php


class Usuario{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }


    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre  ;
    }
    
    function getApellidos(){
        return $this->apellidos ;
    }
    
    function getEmail(){
        return $this->email ;
    }
    
    function getPassword(){
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }
    
    function getRol(){
        return $this->rol;
    }
    
    function getImagen(){
        return $this->imagen;
    }
    
    function setId($id){
        $this->id = $id;
    }

    function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    function setApellidos($apellidos){
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    function setEmail($email){
        $this->email = $this->db->real_escape_string($email);
    }

    function setPassword($password){
        $this->password = $password;
    }

    function setRol($rol){
        $this->rol = $rol;
    }

    function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function save(){
        /*$sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null);";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;*/
        $sql = "INSERT INTO usuarios (id, nombre, apellidos, email, password, rol, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
          // Vincular los valores a los marcadores de posición
          $id = null;
          $nombre = $this->getNombre();
          $apellidos = $this->getApellidos();
          $email = $this->getEmail();
          $password = $this->getPassword();
          $rol = 'user';
          $imagen = null;
          
          $stmt->bind_param("sssssss", $id, $nombre, $apellidos, $email, $password, $rol, $imagen);

          // Ejecutar la consulta
          $result = $stmt->execute();

          // Comprobar si la inserción fue exitosa
        if ($result) {
            return true;
        } else {
            // Manejar errores aquí, por ejemplo, registrarlos o devolver un mensaje de error.
            return false;
        }
      } else {
        // Manejar errores de preparación de la consulta aquí
        echo "Error al preparar la consulta.";
        return false;
      }
    }

    public function login(){
      $result = false;
      $email = $this->email;
      $password = $this->password;
      //Comprobar si existe el usuario
      /*$sql = "SELECT * FROM usuarios WHERE email = '$email'";
      $login = $this->db->query($sql);*/
      $sql = "SELECT * FROM usuarios WHERE email = ?";
      $stmt = $this->db->prepare($sql);

      if ($stmt) {
        // Vincular el valor de $email al marcador de posición
        $stmt->bind_param("s", $email);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $login = $stmt->get_result();

        if($login && $login->num_rows == 1){
          $usuario = $login->fetch_object();

          //Verificar la contraseña
          $verify = password_verify($password, $usuario->password);
          $result = false;
          if($verify){
            $result = $usuario;
          }
        }
      }
      return $result;
    }
}