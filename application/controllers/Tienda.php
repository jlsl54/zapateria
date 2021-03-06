<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends CI_Controller {

	public function index() {

		$result = $this->productos->findAll();
		$result1 = $this->productos->findByLimit(3);
		$result2 = $this->categorias->findAll();
		$result3 = $this->productos->findByCategoria();
		$result4 = $this->marcas->findAll();

		$data = array(
			"findAllProductos" => $result,
			"findByLimitProductos" => $result1,
			"findAllCategorias" => $result2,
			"findByCategoriaProductos" => $result3,
			"findAllMarcas" => $result4
		);

        $this->load->view('templates/header');
		$this->load->view('tienda_view', $data);
		$this->load->view('templates/footer');
	}

	public function detalles($rewrite = "") {

			if($this->productos->findByRewrite($rewrite)):
				$result = $this->productos->findAll();
				$result1 = $this->productos->findAll();
				$result2 = $this->categorias->findByLimit(3);

				$fila = $this->productos->findByRewrite($rewrite);
				$data = array(
					"id" => $fila->productoId,
					"modelo" => $fila->modelo,
					"descripcion" => $fila->descripcion,
					"imagen" => $fila->imagen,
					"precio" => $fila->precioNuevo,
					"findAllCategorias" => $result,
					"findAllMarcas" => $result1,
					"findByLimitProductos" => $result2
				);

				$this->load->view('templates/header');
				$this->load->view('detalles_view', $data);
				$this->load->view('templates/footer');
			else:
				$this->load->view('404');
			endif;


	}

}
