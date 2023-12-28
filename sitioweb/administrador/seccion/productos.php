<?php
include "../template/cabecera.php";
?>
<?php 
$txtid=(isset($_POST['txtid']))?$_POST['txtid']:"";
$txtnombre=(isset($_POST['txtnombre']))?$_POST['txtnombre']:"";
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include ("../config/bd.php");


switch($accion){
    case "agregar":
    $senteciaSQL=$conexion->prepare(" INSERT INTO libros (nombre, imagen) VALUES (:nombre,:imagen);");
      $senteciaSQL->bindParam(':nombre',$txtnombre);
      $fecha= new DateTime();
      $nombreArchivo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";
      $tmpImagen=$_FILES["txtimagen"]["tmp_name"];
      if($tmpImagen!=""){
        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
      }
      
      $senteciaSQL->bindParam(':imagen',$nombreArchivo);
      $senteciaSQL->execute();
        //header("Location:productos.php");
      
        break;
    case "modificar":
    $senteciaSQL=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
    $senteciaSQL->bindParam(':nombre',$txtnombre);
    $senteciaSQL->bindParam(':id',$txtid);
    $senteciaSQL->execute();  
      if($txtimagen!=""){ 


     $senteciaSQL=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
     $senteciaSQL->bindParam(':imagen',$txtimagen);
     $senteciaSQL->bindParam(':id',$txtid);
     $senteciaSQL->execute();
      }
      //header("Location:/seccion/productos.php");
    break;
    case "cancelar":
        header("Location:productos.php");
       
        break;
         case "seleccionar":
    $senteciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
    $senteciaSQL->bindParam(':id',$txtid);
    $senteciaSQL->execute();
    $libro = $senteciaSQL->fetch(PDO::FETCH_LAZY);
    $txtnombre = $libro['nombre'];
     $txtimagen =$libro['imagen'];       
        break;
    case "borrar":
            //con esta instruccion se borra registro de imagen
     
        $senteciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
    $senteciaSQL->bindParam(':id',$txtid);
    $senteciaSQL->execute();
    $libro = $senteciaSQL->fetch(PDO::FETCH_LAZY);
        if (isset($libro["imagen"])&&($libro!=["imagen.jpg"])){
            if(file_exists("../../img/".$libro["imagen"])){
               unlink("../../img/".$libro["imagen"]); 
            }
        }
           //instruccion que borra registro de nombre y id; creando una crpeta de imagenes      
    $senteciaSQL=$conexion->prepare(" DELETE FROM libros  WHERE id=:id");
    $senteciaSQL->bindParam(':id',$txtid);
    $senteciaSQL->execute();
    //header("location:productos.php");
       
        
        break;
        
        
}

$senteciaSQL=$conexion->prepare("SELECT * FROM libros");
 $senteciaSQL->execute();
 $listalibros = $senteciaSQL->fetchAll(PDO::FETCH_ASSOC);




?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
           datos de  Productos
        </div>
        <div class="card-body">
        
        <form method="POST" enctype ="multipart/form-data">
    <div class = "form-group">
    <label for="txtid">ID </label>
    <input type="text" required readonly class="form-control" value="<?php echo $txtid;?>"name="txtid"id="txtid" placeholder="ID">
     </div>
      <div class = "form-group">
    <label for="txtnombre  ">NOMBRE  </label>
    <input type="text" Required class="form-control" value="<?php echo $txtnombre;?>" name="txtnombre"id="txtnombre" placeholder="NOMBRE DEL PRODUCTO">
     </div>
     <div class = "form-group">
    <label for="txtimagen">IMAGEN </label>
   <br/>
    <?php //imagen bajo el selector de archivo
     if($txtimagen!=""){ ?>  
        <img class="img-thumbnail" src="../../img/<?php echo $txtimagen;?>"width="50" alt="imagen borrada">
     
    <?php  
     
    }   
?>

    <input type="file" required class="form-control" name="txtimagen" id="txtimagen" placeholder="NOMBRE DE LA IMAGEN">
     </div>
    <div class="btn-group" role="group" aria-label="">
        <button  type="submit" name="accion"<?php echo ($accion=="seleccionar")?"disabled":"";?>       value ="agregar"  class="btn btn-success">agregar</button>
        <button  type="submit" name="accion"<?php echo ($accion!="seleccionar")?"disabled":"";?> value="modificar"class="btn btn-warning">modificar</button>
        <button  type="submit" name="accion" <?php echo ($accion!="seleccionar")?"disabled":"";?>value="cancelar"class="btn btn-info">cancelar</button>
    </div>

    </form>
    
        </div>
    </div>
    
    
</div>
<div class="col-md-7">
    
    <table class="table table-bordered">
        <thead>
            <tr>  
                <th>ID</th>
                <th>Nombre</th>
                 <th>imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
           <?php foreach($listalibros as $libro) {  ?>
       
        <tbody>
             <tr>
                <td><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                

                <td><img src="../../img/<?php echo $libro['imagen'];?>"width="50" alt="">
                </td>
                <td>    
    
                <form  method="POST">
                <input type="hidden" name="txtid" id="txtid" value="<?php echo $libro['id'];?>"/>
                <input type="submit" name="accion"value="seleccionar"class="btn btn-primary"/>
                <input type="submit" name="accion"value="borrar"class="btn btn-danger"/>
                
                </form>
                </td>
            </tr>
            
            <?php }?>
        </tbody>
    </table>
</div>







<?php
include"../template/footer.php"
?>