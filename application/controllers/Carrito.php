<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends CI_Controller {

	public function index() {
		if(!isset($_SESSION["contador"])) $_SESSION["contador"] = 0;
		$this->load->view('templates/header');
		$this->load->view('carrito_view');
		$this->load->view('templates/footer');
	}

    public function contador() {
        if($this->input->post("id")):
			$c = 0;

			for($i = 0; $i<$_SESSION["contador"]; $i++):
				if($this->input->post("id") == $_SESSION["producto"][$i]):
					$c++;
					$_SESSION["cantidad"][$i] += $this->input->post("cant");
					$fila = $this->productos->findById($_SESSION["producto"][$i]);
					$_SESSION["precioProducto"][$i] = $fila->precioNuevo * $_SESSION["cantidad"][$i];
				endif;
			endfor;

			if($c == 0):
	            $_SESSION["producto"][$_SESSION["contador"]] = $this->input->post("id");
	            $_SESSION["cantidad"][$_SESSION["contador"]] = $this->input->post("cant");

	            $fila = $this->productos->findById($_SESSION["producto"][$_SESSION["contador"]]);
	            $_SESSION["precioProducto"][$_SESSION["contador"]] = $fila->precioNuevo * $this->input->post("cant");
	            $_SESSION["contador"]++;
			endif;
        endif;

        if(!isset($_SESSION["producto"]) || (count($_SESSION["producto"]) == 0)) echo "<tr><td colspan='6' align='center' class='cart_description'>No hay productos en el carrito</td></tr>";

        for($i = 0; $i<$_SESSION["contador"]; $i++):
            if(array_key_exists($i, $_SESSION["producto"])):
                $fila = $this->productos->findById($_SESSION["producto"][$i]);
                    echo '
            <tr>
                <td class="cart_product">
                    <a href=""><img width="60" src="' . base_url() . 'assets/images/productos/' . $fila->imagen . '" alt=""></a>
                </td>
                <td class="cart_description">
                    <h4><a href="">' . $fila->titulo . '</a></h4>
                    <p>ID: ' . $fila->productoId . '</p>
                </td>
                <td class="cart_price">
                    <p>$ ' . $fila->precioNuevo . '</p>
                </td>
                <td class="cart_quantity">
                    <div class="cart_quantity_button">
                        <a class="cart_quantity_up" href=""> + </a>
                        <input class="cart_quantity_input" data-id="' . $i . '" type="text" name="quantity" value="' . $_SESSION["cantidad"][$i] . '" autocomplete="off" size="2" disabled>
                        <a class="cart_quantity_down" href=""> - </a>
                    </div>
                </td>
                <td class="cart_total">
                    <p class="cart_total_price">$ ' . number_format($_SESSION["precioProducto"][$i], 2, '.', '') . '</p>
                </td>
                <td class="cart_delete">
                    <a class="cart_quantity_delete" href="#" data-id="' . $i . '"><i class="fa fa-times"></i></a>
                </td>
            </tr>';
            endif;
        endfor;
	}

	public function eliminar() {
		$id = $this->input->post("id");
		unset($_SESSION["producto"][$id]);

		$precioTotal = 0;
		for($i = 0; $i<$_SESSION["contador"]; $i++):
			if(array_key_exists($i, $_SESSION["producto"])):
				$precioTotal += $_SESSION["precioProducto"][$i];
				$data = array("precioTotal" => $precioTotal);
				$this->session->set_userdata($data);
			endif;
		endfor;

		if(!isset($_SESSION["producto"]) || (count($_SESSION["producto"]) == 0)) echo "true";
		else echo "$ " . number_format($precioTotal, 2, '.', '');
	}

	public function precio_total() {
		$precioTotal = 0;
		for($i = 0; $i<$_SESSION["contador"]; $i++) {
			if(array_key_exists($i, $_SESSION["producto"])) {
				$precioTotal += $_SESSION["precioProducto"][$i];
				$data = array("precioTotal" => $precioTotal);
				$this->session->set_userdata($data);
			}
		}
		echo "$ " . number_format($precioTotal, 2, '.', '');
	}

	public function cantidad_producto() {
		$id = $this->input->post("id");
		$cantidad = $this->input->post("cantidad");
		$fila = $this->productos->findById($_SESSION["producto"][$id]);
		$_SESSION["cantidad"][$id] = $cantidad;
		$_SESSION["precioProducto"][$id] = $fila->precioNuevo * $cantidad;

		echo "$ " . number_format($_SESSION["precioProducto"][$id], 2, '.', '');
	}
}
