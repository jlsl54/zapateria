<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if($this->session->userdata("admin-logeado") == FALSE):
            $this->load->view("admin/login");
        else:
            redirect(base_url() . "admin/dashboard");
        endif;

    }

	public function dashboard($metodo = "") {

            if($this->session->userdata("admin-logeado") == TRUE):
                if($metodo == NULL):
                    $result1 = $this->categorias->findAll();
            		$result2 = $this->marcas->findAll();

            		$data = array(
            			"findAllCategorias" => $result1,
            			"findAllAutores" => $result2
            		);

                    $this->load->view("admin/templates/header");
                    $this->load->view("admin/dashboard", $data);
                    $this->load->view("admin/templates/footer");
                else:
                    switch($metodo) {
                        case 1:
                            $categoria = $this->input->post("categoria");
                            $rewrite = $this->input->post("rewrite");
                            $this->categorias->addCategoria($categoria, $rewrite);
                            break;
                        case 2:
                            $marca = $this->input->post("marca");
                            $this->marcas->addMarca($marca);
                            break;
                        case 3:
                            $titulo = $this->input->post("modelo");
                            $url = $this->input->post("url");
                            $precio = $this->input->post("precio");
                            $descripcion = $this->input->post("descripcion");
                            $categoria = $this->input->post("categoria");
                            $marca = $this->input->post("marca");

                            if(isset($_FILES["imagen"])){

                                   move_uploaded_file($_FILES["imagen"]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/github/web-bookstore/assets/images/libros/".$url.".jpg");
                             }

                             $this->productos->addProducto($model, $url, $precio, $descripcion, $url . ".jpg", $categoria, $marca);

                            break;
                    }
                endif;
    		else:
    			$this->load->view('404');
    		endif;


	}

}
