<?php

class Categoria{
    private $id;
    private $nombre;
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function getAll(){
        /*$categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;*/

        $stmt = $this->db->prepare("SELECT * FROM categorias ORDER BY id DESC");
        $stmt->execute();
        $categorias = $stmt->get_result();
        $stmt->close();
        return $categorias;
    }

    public function getOne(){
        /*$categoria = $this->db->query("SELECT * FROM categorias WHERE id ={$this->getId()}");
        return $categoria->fetch_object();*/
        $id = $this->getId();
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoria = $result->fetch_object();
        $stmt->close();
        return $categoria;
    }

    public function save(){
        /*$sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }*/
    $nombre = $this->getNombre();
    
    // Utilizar una consulta preparada
    $stmt = $this->db->prepare("INSERT INTO categorias VALUES(NULL, ?)");
    
      if ($stmt) {
          $stmt->bind_param("s", $nombre); // "s" indica que se espera una cadena (string)
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
  }
?>