<?php

 class Marcas extends CI_Model {

     public function findAll() {
         return $this->db->get('marcas');
     }

     public function addMarca($marca = "") {
         $data = array(
             "nombre" => $marca
         );
         return $this->db->insert('marcas', $data);
     }
 }
