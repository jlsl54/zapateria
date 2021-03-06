<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index() {
		$result = $this->productos->findByLimit(6);
		$result1 = $this->productos->findByLimit(3);
		$result2 = $this->categorias->findAll();
		$result3 = $this->productos->findByCategoria();
		$result4 = $this->marcas->findAll();

		$data = array(
			"findByLimitProductosInicio" => $result,
			"findByLimitProductos" => $result1,
			"findAllCategorias" => $result2,
			"findByCategoriaProductos" => $result3,
			"findAllMarcas" => $result4
		);

		if(!isset($_SESSION["contador"])) $_SESSION["contador"] = 0;

		$this->load->view('templates/header');
		$this->load->view('inicio_view', $data);
		$this->load->view('templates/footer');
	}

}
