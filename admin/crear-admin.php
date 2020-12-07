<?php
include_once('funciones/sesiones.php');
include_once('funciones/funciones.php');
include_once('templates/header.php');
include_once('templates/barra.php');
include_once('templates/navegacion.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Crear Administrador
			<small>Llena el formulario para crear un administrador</small>
		</h1>
	</section>
	<div class="row">
		<div class="col-md-8">
			<!-- Main content -->
			<section class="content">

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Crear Admin</h3>
					</div>
					<div class="box-body">
						<!-- form start -->
						<form role="form" name="guardar-registro" id="guardar-registro" method="post" action="modelo-admin.php">
							<div class="box-body">
								<div class="form-group">
									<label for="usuario">Usuarios:</label>
									<input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario">
								</div>
								<div class="form-group">
									<label for="nombre">Nombre:</label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu Nombre Completo">
								</div>
								<div class="form-group">
									<label for="nivel">Seleccione un nivel</label><br>
									<select id="nivel" name="nivel" required>
										<option value="">--Seleccione un nivel--</option>
										<option value="1">Admin</option>
										<option value="0">Usuario</option>
									</select>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" placeholder="Password Para Iniciar Sesión">
								</div>
								<div class="form-group">
									<label for="password">Repetir Password</label>
									<input type="password" class="form-control" id="repetir_password" name="password" placeholder="Password Para Iniciar Sesión">
									<span class="help-block" id="resultado_password"></span>
								</div>
							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<input type="hidden" name="registro" value="nuevo">
								<button type="submit" class="btn btn-primary" id="crear_registro_admin">Añadir</button>
							</div>
						</form>
					</div>
					<!-- /.box-footer-->
				</div>
				<!-- /.box -->

			</section>
			<!-- /.content -->
		</div>
	</div>
</div>
<!-- /.content-wrapper -->

<?php
include_once('templates/footer.php');
?>