<?php
/*
<section id="advertisement">
		<div class="container">
			<img src="' . base_url() . 'assets/images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
 * 
 * 
 * el rango
 * 						<div class="price-range"><!--price-range-->
							<h2>Rango</h2>
							<div class="well text-center">
								 <input type="text" class="span2" value="" data-slider-min="5" data-slider-max="60" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b class="pull-left">€ 5</b> <b class="pull-right">€ 60</b>
							</div>
						</div><!--/price-range-->

*/
echo'
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Categoría</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->';
						foreach ($findAllCategorias->result() as $categoria):
							echo '
                                                            <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                            <h6 class="panel-title"><a href="#">' . $categoria->descripcion . '</a></h6>
                                                            </div>
                                                            </div>';
						endforeach;
						echo '
						</div><!--/category-products-->

						<div class="brands_products"><!--brands_products-->
							<h2>Marcas</h2>
							<div class="brands-name">
                                                           <small>
								<ul class="nav nav-pills nav-stacked">';
								foreach ($findAllAutores->result() as $autores):
									echo '
									<small><li><a href="#">' . $autores->nombre . '</a></li></small>';
								endforeach;
								echo '
								</ul>
                                                            </small>    
							</div>
						</div><!--/brands_products-->

<!-- rango  -->
						<div class="shipping text-center"><!--shipping-->
							<img src="' . base_url() . 'assets/images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->

					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
					<h2 class="title text-center">ÚLTIMOS PRODUCTOS</h2>';
					foreach ($findAllLibros->result() as $libro):
						echo '<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="' . base_url() . 'assets/images/libros/' . $libro->imagen . '" alt="" />
										<h2> ' . $libro->precioNuevo . '€</h2>
										<p>' . $libro->titulo . '</p>
										<a href="' . base_url() . 'tienda/' . $libro->rewrite . '" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Agregar al carrito</a>
									</div>
									<div class="product-overlay">
										<div class="overlay-content">
											<h2> ' . $libro->precioNuevo . '€</h2>
											<p>' . $libro->titulo . '</p>
											<a href="' . base_url() . 'tienda/' . $libro->rewrite . '" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Agregar al carrito</a>
										</div>
									</div>
								</div>
							</div>
						</div>';
					endforeach;
				echo '

					</div><!--features_items-->
		<!--			<ul class="pagination">
						<li class="active"><a href="">1</a></li>
						<li><a href="">2</a></li>
						<li><a href="">3</a></li>
						<li><a href="">&raquo;</a></li>
					</ul>-->
				</div>
			</div>
		</div>
	</section>';
