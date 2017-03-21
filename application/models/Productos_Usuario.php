<?php

 class Libros_Usuario extends CI_Model {

     public function findByUsuario($usuario = "") {
         $this->db->from('productos_usuario');
         $this->db->join('productos', 'productos_usuario.productoid = productos.productoid', "left");
         $this->db->join('usuarios', 'productos_usuario.usuarioId = usuarios.usuarioid', "left");
         $this->db->where("usuarios.usuarioid", $usuario);
         $this->db->group_by(array("usuarios.usuarioId", "productos.productoId"));
         return $this->db->get();
     }

     public function addCompra($usuarioId = "", $productoId = "", $cantidad = "") {
            date_default_timezone_set('Europa/Madrid');
            $data = array(
                "usuarioId" => $usuarioId,
                "productoId" => $productoId,
                "cantidad" => $cantidad,
                "fecha" => date("Y-m-d H:i:s")
            );

            return $this->db->insert('productos_usuario', $data);
     }
 }
