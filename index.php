<?php include_once 'includes/templates/header.php'; ?>
<section class="seccion contenedor">
	<h2>desarrollador web</h2>
	<p>
		Es un programador especializado, o dedicado de forma específica, en desarrollar aplicaciones de la World Wide Web (WWW) o aplicaciones distribuidas en red que se ejecutan mediante HTTP desde un servidor web (<span class="host_client"><a href="https://es.wikipedia.org/wiki/Alojamiento_web" target="_blanck">Hosting</a></span>) a un navegador web (<span class="host_client"><a href="https://es.wikipedia.org/wiki/Cliente_(inform%C3%A1tica)" target="_blanck">Cliente</a></span>).
	</p>
</section>
<!--.seccion-->
<section class="seccion contenedor diseño">
	<h2>diseñador web</h2>
	<p>El diseño web tiene una amplia aplicación en los sectores comerciales de Tradicionales.</p>

	<P>Todas nuestras webs están realizadas a medida, son absolutamente únicas y están orientadas hacia los objetivos de tu marca.</P>
	<p>diseñar una web requiere una serie de pasos, a continuación detallamos los más básicos</p>

	<h3>Defina objetivos</h3>

	<p>Identifique el propósito que tendrá su website. Un sitio web puede servir como medio publicitario, como catálogo para ventas por Internet, como un soporte para atender dudas o comentarios de sus clientes, entre otros.</p>

	<h3>Asigne tareas</h3>

	<p>Este equipo deberá trabajar de la mano de personas que laboran dentro de la empresa. Defina quiénes serán esas personas, qué deberán proveer a la empresa que desarrollará la website y a través de qué medios se mantendrán en contacto durante todo el proyecto.</p>

	<h3>Defina una estructura</h3>

	<p>Establezca las secciones o apartados que tendrá el sitio web y qué contenido deberá presentarse en cada una de estas secciones.</p>

	<h3>Pruébelo</h3>

	<p>Luego de haber aprobado el diseño, se pasará a la etapa de programación donde la empresa encargada del proyecto le brindará una dirección provisional para que usted pueda navegar por el sitio web antes de que sea publicado, para hacer correcciones y observaciones.</p>

	<h3>Tareas de mantenimiento</h3>

	<p>Publicar su sitio web no es el cierre del proyecto, es apenas el inicio. Ponga atención también a los insumos y comentarios de su público para tomar en cuenta sus necesidades y formas de interactuar con el sitio web.</p>
</section>
<!--.seccion-->
<section class="programa">
	<div class="contenedor-video">
		<video autoplay loop poster="img/bg-talleres.jpg">
			<source src="video/video.mp4" type="video/mp4">
			<source src="video/video.webm" type="video/webm">
			<source src="video/video.ogv" type="video/ogg">
		</video>
	</div>
	<!--.contenedor-video-->
	<div class="contenido-programa">
		<div class="contenedor">
			<div class="programa-evento">
				<h2>Programa del Evento</h2>
				<?php
				mb_http_output('UTF-8');

				try {
					require_once('includes/funciones/bd_conexion.php');
					$sql = " SELECT * FROM `categoria_evento` ";
					$resultado = $conn->query($sql);
				} catch (Exception $e) {
					echo $e->getMessage();
				}

				?>

				<nav class="menu-programa">
					<?php while ($cat = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
						<?php $categoria = $cat['cat_evento']; ?>
						<a href="#<?php echo strtolower($categoria) ?>"><i class="fas <?php echo $cat['icono']; ?>" aria-hidden="true"></i><?php echo $categoria ?>
						</a>
					<?php } ?>
				</nav>

				<?php
				// Esto le dice a PHP que usaremos cadenas UTF-8 hasta el final
				mb_internal_encoding('UTF-8');



				try {
					require_once('includes/funciones/bd_conexion.php');
					$sql = " SELECT `evento_id`, `nombre_evento`, `fecha_evento`, `hora_evento`, `cat_evento`, `icono`, `nombre_invitado`, `apellido_invitado` ";
					$sql .= " FROM `eventos` ";
					$sql .= " INNER JOIN `categoria_evento` ";
					$sql .= " ON eventos.id_cat_evento=categoria_evento.id_categoria ";
					$sql .= " INNER JOIN `invitados` ";
					$sql .= " ON eventos.id_inv=invitados.invitado_id ";
					$sql .= " AND eventos.id_cat_evento= 1 ";
					$sql .= " ORDER BY `evento_id` LIMIT 2; ";
					$sql .= " SELECT `evento_id`, `nombre_evento`, `fecha_evento`, `hora_evento`, `cat_evento`, `icono`, `nombre_invitado`, `apellido_invitado` ";
					$sql .= " FROM `eventos` ";
					$sql .= " INNER JOIN `categoria_evento` ";
					$sql .= " ON eventos.id_cat_evento=categoria_evento.id_categoria ";
					$sql .= " INNER JOIN `invitados` ";
					$sql .= " ON eventos.id_inv=invitados.invitado_id ";
					$sql .= " AND eventos.id_cat_evento= 2 ";
					$sql .= " ORDER BY `evento_id` LIMIT 2; ";
					$sql .= " SELECT `evento_id`, `nombre_evento`, `fecha_evento`, `hora_evento`, `cat_evento`, `icono`, `nombre_invitado`, `apellido_invitado` ";
					$sql .= " FROM `eventos` ";
					$sql .= " INNER JOIN `categoria_evento` ";
					$sql .= " ON eventos.id_cat_evento=categoria_evento.id_categoria ";
					$sql .= " INNER JOIN `invitados` ";
					$sql .= " ON eventos.id_inv=invitados.invitado_id ";
					$sql .= " AND eventos.id_cat_evento= 3 ";
					$sql .= " ORDER BY `evento_id` LIMIT 2; ";
				} catch (Exception $e) {
					echo $e->getMessage();
				}

				?>

				<?php if (!$conn->multi_query($sql)) {
					echo "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				?>

				<?php do {
					$resultado = $conn->store_result();
					$row = $resultado->fetch_all(MYSQLI_ASSOC); ?>

					<?php $i = 0; ?>

					<?php foreach ($row as $evento) { ?>
						<?php if ($i % 2 == 0) { ?>
							<div id="<?php echo strtolower($evento['cat_evento']); ?>" class="info-curso ocultar clearfix">
							<?php } ?>

							<div class="detalle-evento">
								<h3><?php
									echo utf8_decode($evento['nombre_evento']);
									?>
								</h3>
								<p> <i class="fas fa-clock" aria-hidden="true"></i><?php echo $evento['hora_evento']; ?></p>
								<p> <i class="fas fa-calendar" aria-hidden="true"></i> <?php echo $evento['fecha_evento']; ?></p>
								<p> <i class="fas fa-user" aria-hidden="true"></i><?php echo $evento['nombre_invitado'] . " " . $evento['apellido_invitado']; ?></p>
							</div>

							<?php if ($i % 2 == 1) { ?>
								<a href="calendario.php" class="button float-right">Ver Todos</a>
							</div>
							<!--#talleres-->
						<?php }; ?>
						<?php $i++; ?>
					<?php }; ?>
					<?php $resultado->free(); ?>

				<?php } while ($conn->more_results() && $conn->next_result());	?>


			</div>
			<!--.programa-evento-->
		</div>
		<!--.contenedor-->
	</div>
	<!--contenido-programa-->
</section>
<!--.programa-->

<?php include_once 'includes/templates/invitados.php'; ?>

<div class="contador parallax">
	<div class="contenedor">
		<ul class="resumen-evento clearfix">
			<li>
				<p class="numero">0</p>Invitados
			</li>
			<li>
				<p class="numero">0</p>Talleres
			</li>
			<li>
				<p class="numero">0</p>Días
			</li>
			<li>
				<p class="numero">0</p>Conferencias
			</li>
		</ul>
	</div>
</div>

<section class="precios seccion">
	<h2>Precios</h2>
	<div class="contenedor">
		<ul class="lista-precios clearfix">
			<li>
				<div class="tabla-precio">
					<h3>Pase por día</h3>
					<p class="numero">30€</p>
					<ul>
						<li><i class="fas fa-check check"></i>Bocadillos Gratis</li>
						<li><i class="fas fa-check check"></i>Todos las Conferencias</li>
						<li><i class="fas fa-check check"></i>Talleres</li>
					</ul>
					<a href="#" class="button hollow">Comprar</a>
				</div>
			</li>
			<li>
				<div class="tabla-precio">
					<h3>Todos los días</h3>
					<p class="numero">50€</p>
					<ul>
						<li><i class="fas fa-check check"></i>Bocadillos Gratis</li>
						<li><i class="fas fa-check check"></i>Todos las Conferencias</li>
						<li><i class="fas fa-check check"></i>Talleres</li>
					</ul>
					<a href="#" class="button ">Comprar</a>
				</div>
			</li>
			<li>
				<div class="tabla-precio">
					<h3>Pase por dos día</h3>
					<p class="numero">45€</p>
					<ul>
						<li><i class="fas fa-check check"></i>Bocadillos Gratis</li>
						<li><i class="fas fa-check check"></i>Todos las Conferencias</li>
						<li><i class="fas fa-check check"></i>Talleres</li>
					</ul>
					<a href="#" class="button hollow">Comprar</a>
				</div>
			</li>
		</ul>
	</div>
</section>

<div id="mapa" class="mapa"></div>

<section class="seccion">
	<h2>Testimoniales</h2>
	<div class="testimoniales contenedor clearfix">
		<div class="testimonial">
			<blockquote>
				<p><i class="fas fa-quote-left quote"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro perspiciatis corrupti animi impedit aperiam, culpa unde laborum error est dolorem, iure, recusandae adipisci obcaecati quasi. Consectetur esse quaerat natus.</p>
				<footer class="info-testimonial clearfix">
					<img src="img/testimonial.jpg" alt="imagen testimonial">
					<cite>Oswaldo Aponte Cifuentes <span>Diseñador en @prisma</span></cite>
				</footer>
			</blockquote>
		</div>
		<!--.testimonial-->
		<div class="testimonial">
			<blockquote>
				<p><i class="fas fa-quote-left quote"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro perspiciatis corrupti animi impedit aperiam, culpa unde laborum error est dolorem, iure, recusandae adipisci obcaecati quasi. Consectetur esse quaerat natus.</p>
				<footer class="info-testimonial clearfix">
					<img src="img/testimonial.jpg" alt="imagen testimonial">
					<cite>Oswaldo Aponte Cifuentes <span>Diseñador en @prisma</span></cite>
				</footer>
			</blockquote>
		</div>
		<!--.testimonial-->
		<div class="testimonial">
			<blockquote>
				<p><i class="fas fa-quote-left quote"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro perspiciatis corrupti animi impedit aperiam, culpa unde laborum error est dolorem, iure, recusandae adipisci obcaecati quasi. Consectetur esse quaerat natus.</p>
				<footer class="info-testimonial clearfix">
					<img src="img/testimonial.jpg" alt="imagen testimonial">
					<cite>Oswaldo Aponte Cifuentes <span>Diseñador en @prisma</span></cite>
				</footer>
			</blockquote>
		</div>
		<!--.testimonial-->
	</div>
	<!--.testimoniales-->
</section>

<div class="newsletter parallax">
	<div class="contenido contenedor">
		<p>Registrate al Newsletter:</p>
		<h3>GdlWebcam</h3>
		<a href="#mc_embed_signup" class="boton_newsletter button transparente">Registro</a>
	</div>
	<!--.contenido-->
</div>
<!--.newslatter-->

<section class="seccion">
	<h2>Faltan</h2>
	<div class="cuenta-regresiva contenedor">
		<ul class="clearfix">
			<li>
				<p id="dias" class="numero"></p>días
			</li>
			<li>
				<p id="horas" class="numero"></p>horas
			</li>
			<li>
				<p id="minutos" class="numero"></p>minutos
			</li>
			<li>
				<p id="segundos" class="numero"></p>segundos
			</li>
		</ul>
	</div>
	<!--.cuenta-regresiva-->
</section>
<?php include_once 'includes/templates/footer.php'; ?>