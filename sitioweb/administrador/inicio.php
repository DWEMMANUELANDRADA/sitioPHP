<?php
include"template/cabecera.php";
?>
            <div class="col-md-12">
               <div class="jumbotron">
                <h1 class="display-3">HOLA <?php echo $nombreUsuario;?> </h1>
                <p class="lead">DESDE AQUI PUEDES ADMINISTRAR EL SITIO, TIENES TODAS LAS CREDENCIALES!!</p>
                <hr class="my-2">
                 <p>puedes acceder a la base de dalros de los productos, modificarlos, agregarles imagen, etc.</p>
                <p class="lead">
                <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar sitio</a>
                </p>
            </div> 
            <?php
            include"template/footer.php";
            ?>
       
            
      