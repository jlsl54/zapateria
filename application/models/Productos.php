<?php

 class Productos extends CI_Model {

     public function findAll() {
         $this->db->from('productos');
         $this->db->order_by("productoId", "desc");
         return $this->db->get();
     }

     public function findByRewrite($rewrite = "") {
         $result = $this->db->get_where('productos', array('rewrite' => $rewrite),1);
         return $result->row();
     }

     public function findByLimit($limit = "") {
         $this->db->order_by("productoId", "desc");
         return $this->db->get('productos', $limit);
     }

     public function findByCategoria() {
         $this->db->order_by("productoId", "desc");
         return $this->db->get('productos');
     }

     public function findById($id = "") {
         $result = $this->db->get_where('productos', array('productoId' => $id), 1);
         return $result->row();

     }

     public function addProducto($modelo = "", $url = "", $precio = "", $descripcion = "", $imagen = "", $categoria = "", $marca = "") {
         $data = array(
             "titulo" => $modelo,
             "rewrite" => $url,
             "precioNuevo" => $precio,
             "descripcion" => $descripcion,
             "imagen" => $imagen,
             "categoriaId" => $categoria,
             "autorId" => $marca
         );

         return $this->db->insert('productos', $data);
     }
 }
