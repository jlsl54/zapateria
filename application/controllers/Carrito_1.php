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
				if($this->input->post("id") == $_SESSION["libro"][$i]):
					$c++;
					$_SESSION["cantidad"][$i] += $this->input->post("cant");
					$fila = $this->libros->findById($_SESSION["libro"][$i]);
					$_SESSION["precioLibro"][$i] = $fila->precioNuevo * $_SESSION["cantidad"][$i];
				endif;
			endfor;

			if($c == 0):
	            $_SESSION["libro"][$_SESSION["contador"]] = $this->input->post("id");
	            $_SESSION["cantidad"][$_SESSION["contador"]] = $this->input->post("cant");

	            $fila = $this->libros->findById($_SESSION["libro"][$_SESSION["contador"]]);
	            $_SESSION["precioLibro"][$_SESSION["contador"]] = $fila->precioNuevo * $this->input->post("cant");
	            $_SESSION["contador"]++;
			endif;
        endif;

        if(!isset($_SESSION["libro"]) || (count($_SESSION["libro"]) == 0)) echo "<tr><td colspan='6' align='center' class='cart_description'>No hay libros en el carrito</td></tr>";

        for($i = 0; $i<$_SESSION["contador"]; $i++):
            if(array_key_exists($i, $_SESSION["libro"])):
                $fila = $this->libros->findById($_SESSION["libro"][$i]);
                    echo '
            <tr>
                <td class="cart_product">
                    <a href=""><img width="60" src="' . base_url() . 'assets/images/libros/' . $fila->imagen . '" alt=""></a>
                </td>
                <td class="cart_description">
                    <h4><a href="">' . $fila->titulo . '</a></h4>
                    <p>ID: ' . $fila->libroId . '</p>
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
                    <p class="cart_total_price">$ ' . number_format($_SESSION["precioLibro"][$i], 2, '.', '') . '</p>
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
		unset($_SESSION["libro"][$id]);

		$precioTotal = 0;
		for($i = 0; $i<$_SESSION["contador"]; $i++):
			if(array_key_exists($i, $_SESSION["libro"])):
				$precioTotal += $_SESSION["precioLibro"][$i];
				$data = array("precioTotal" => $precioTotal);
				$this->session->set_userdata($data);
			endif;
		endfor;

		if(!isset($_SESSION["libro"]) || (count($_SESSION["libro"]) == 0)) echo "true";
		else echo "$ " . number_format($precioTotal, 2, '.', '');
	}

	public function precio_total() {
		$precioTotal = 0;
		for($i = 0; $i<$_SESSION["contador"]; $i++) {
			if(array_key_exists($i, $_SESSION["libro"])) {
				$precioTotal += $_SESSION["precioLibro"][$i];
				$data = array("precioTotal" => $precioTotal);
				$this->session->set_userdata($data);
			}
		}
		echo "$ " . number_format($precioTotal, 2, '.', '');
	}

	public function cantidad_libro() {
		$id = $this->input->post("id");
		$cantidad = $this->input->post("cantidad");
		$fila = $this->libros->findById($_SESSION["libro"][$id]);
		$_SESSION["cantidad"][$id] = $cantidad;
		$_SESSION["precioLibro"][$id] = $fila->precioNuevo * $cantidad;

		echo "$ " . number_format($_SESSION["precioLibro"][$id], 2, '.', '');
	}
}
