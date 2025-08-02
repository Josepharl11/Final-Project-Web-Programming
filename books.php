<?php 
include 'config.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'create') {
        $stmt = $pdo->prepare('INSERT INTO titulos (id_titulo, titulo, tipo, id_pub, precio, avance, total_ventas, notas, fecha_pub, contrato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)');
        $stmt->execute([$_POST['id_titulo'], $_POST['titulo'], $_POST['tipo'], $_POST['id_pub'], $_POST['precio'], $_POST['avance'], $_POST['total_ventas'], $_POST['notas'], $_POST['contrato']]);
        $mensaje = "Libro agregado exitosamente";
    }

    else if ($_POST['action'] == 'update') {
      try {
         $stmt = $pdo->prepare('UPDATE titulos SET titulo = ?, tipo = ?, id_pub = ?, precio = ?, avance = ?, total_ventas = ?, notas = ?, contrato = ? WHERE id_titulo = ?');
         if ($stmt->execute([$_POST['titulo'], $_POST['tipo'], $_POST['id_pub'], $_POST['precio'], $_POST['avance'], $_POST['total_ventas'], $_POST['notas'], $_POST['contrato'], $_POST['id_titulo']])) {
            if ($stmt->rowCount() > 0) {
               $mensaje = "Libro actualizado exitosamente";
            } else {
               $mensaje = "No se realizaron cambios en el libro";
            }
         } else {
            $mensaje = "Error al actualizar el libro";
         }
      } catch(PDOException $e) {
         $mensaje = "Error al actualizar: " . $e->getMessage();
         error_log("Error en la actualización: " . $e->getMessage());
      }
    }

    else if ($_POST['action'] == 'delete') {
        $stmt = $pdo->prepare('DELETE FROM titulos WHERE id_titulo = ?');
        $stmt->execute([$_POST['id_titulo']]);
        $mensaje = "Libro eliminado exitosamente";
    }
}

$stmt = $pdo->query('SELECT id_titulo, titulo, tipo, precio, id_pub, avance, total_ventas, notas, contrato FROM titulos');
$titulos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Reyes Libreria</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout Books-bg">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div> <a href="index.html"><h1 style="color: white; padding-top:15px"><b>Reyes Libreria</b></h1></a> </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <div class="menu-area">
                        <div class="limit-box">
                           <nav class="main-menu">
                              <ul class="menu-area-main">
                                 <li> <a href="index.html">Inicio</a> </li>
                                 <li> <a href="about.html">Sobre nosotros</a> </li>
                                 <li class="active"><a href="books.php">Nuestros libros</a> </li>
                                 <li><a href="autores.php">Autores</a></li>
                                 <li><a href="contact.php">Contáctenos</a></li>
                              </ul>
                           </nav>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         </div>
         <!-- end header inner -->
      </header>
      <!-- end header -->
      <div class="about-bg">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="abouttitle">
                     <h2>Nuestros libros</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Books -->
      <div class="Books">
         <div class="container">
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <div class="titlepage">
                     <span>Éstos son los libros que tenemos disponibles en nuestra Biblioteca.</span> 
                  </div>
               </div>
            </div>
            <div class="row box">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                  <div class="book-box">
                     <figure><img src="images/book-1.jpg" alt="img"/></figure>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="book-box">
                     <figure><img src="images/book-2.jpg" alt="img"/></figure>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                  <div class="book-box">
                     <figure><img src="images/book-1.jpg" alt="img"/></figure>
                  </div>
               </div>
               <div class="col-md-6 offset-md-3">
               </div>
            </div>
         <div class="row box tabla mt-5">
            <div class="col-md-12 mb-3">
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBookModal">
                  Agregar Nuevo Libro
               </button>
            </div>
            <?php if ($mensaje): ?>
               <div class="col-md-12">
                  <div class="alert alert-success">
                     <?php echo $mensaje; ?>
                  </div>
               </div>

            <?php endif; ?>
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Título</th>
                           <th>Tipo</th>
                           <th>Precio</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($titulos as $titulo): ?>
                        <tr>
                           <td><?php echo htmlspecialchars($titulo['id_titulo'] ?? ''); ?></td>
                           <td><?php echo htmlspecialchars($titulo['titulo'] ?? ''); ?></td>
                           <td><?php echo htmlspecialchars($titulo['tipo'] ?? ''); ?></td>
                           <td><?php echo htmlspecialchars($titulo['precio'] ?? ''); ?></td>
                           <td>
                              <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editBookModal" 
                                 data-id="<?php echo $titulo['id_titulo']; ?>"
                                 data-titulo="<?php echo $titulo['titulo']; ?>"
                                 data-tipo="<?php echo $titulo['tipo']; ?>"
                                 data-precio="<?php echo $titulo['precio']; ?>"
                                 data-id_pub="<?php echo htmlspecialchars($titulo['id_pub']); ?>"
                                 data-avance="<?php echo htmlspecialchars($titulo['avance']); ?>"
                                 data-total_ventas="<?php echo htmlspecialchars($titulo['total_ventas']); ?>"
                                 data-notas="<?php echo htmlspecialchars($titulo['notas']); ?>"
                                 data-contrato="<?php echo htmlspecialchars($titulo['contrato']); ?>">
                                 Editar
                              </button>
                              <form method="POST" style="display: inline;">
                                 <input type="hidden" name="action" value="delete">
                                 <input type="hidden" name="id_titulo" value="<?php echo $titulo['id_titulo']; ?>">
                                 <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este libro?')">Eliminar</button>
                              </form>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
            </div>

         <!-- Modal para Agregar Libro -->
         <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="addBookModalLabel">Agregar Nuevo Libro</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <form method="POST">
                     <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="form-group">
                           <label>ID Título</label>
                           <input type="text" class="form-control" name="id_titulo" required>
                        </div>
                        <div class="form-group">
                           <label>Título</label>
                           <input type="text" class="form-control" name="titulo" required>
                        </div>
                        <div class="form-group">
                           <label>Tipo</label>
                           <input type="text" class="form-control" name="tipo" required>
                        </div>
                        <div class="form-group">
                           <label>ID Publicador</label>
                           <input type="text" class="form-control" name="id_pub" required>
                        </div>
                        <div class="form-group">
                           <label>Precio</label>
                           <input type="number" step="0.01" class="form-control" name="precio">
                        </div>
                        <div class="form-group">
                           <label>Avance</label>
                           <input type="number" step="0.01" class="form-control" name="avance">
                        </div>
                        <div class="form-group">
                           <label>Total Ventas</label>
                           <input type="number" class="form-control" name="total_ventas">
                        </div>
                        <div class="form-group">
                           <label>Notas</label>
                           <textarea class="form-control" name="notas"></textarea>
                        </div>
                        <div class="form-group">
                           <label>Contrato</label>
                           <select class="form-control" name="contrato">
                              <option value="1">Sí</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Libro</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         
      <!-- Modal para Editar Libro -->
      <div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="editBookModalLabel">Editar Libro</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form method="POST">
                  <div class="modal-body">
                     <input type="hidden" name="action" value="update">
                     <input type="hidden" name="id_titulo" id="edit_id_titulo">
                     <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" name="titulo" id="edit_titulo" required>
                     </div>
                     <div class="form-group">
                        <label>Tipo</label>
                        <input type="text" class="form-control" name="tipo" id="edit_tipo" required>
                     </div>
                     <div class="form-group">
                        <label>Precio</label>
                        <input type="number" step="0.01" class="form-control" name="precio" id="edit_precio">
                     </div>
                     <div class="form-group">
                        <label>ID Publicador</label>
                        <input type="text" class="form-control" name="id_pub" id="edit_id_pub" required>
                     </div>
                     <div class="form-group">
                        <label>Avance</label>
                        <input type="number" step="0.01" class="form-control" name="avance" id="edit_avance">
                     </div>
                     <div class="form-group">
                        <label>Total Ventas</label>
                        <input type="number" class="form-control" name="total_ventas" id="edit_total_ventas">
                     </div>
                     <div class="form-group">
                        <label>Notas</label>
                        <textarea class="form-control" name="notas" id="edit_notas"></textarea>
                     </div>
                     <div class="form-group">
                        <label>Contrato</label>
                        <select class="form-control" name="contrato" id="edit_contrato">
                           <option value="1">Sí</option>
                           <option value="0">No</option>
                        </select>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                     <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <!-- end Books -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>

      <script>
      $(document).ready(function() {
         $('.loader_bg').fadeOut('slow');
         $('#editBookModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            
            var modal = $(this);
            modal.find('#edit_id_titulo').val(button.data('id'));
            modal.find('#edit_titulo').val(button.data('titulo'));
            modal.find('#edit_tipo').val(button.data('tipo'));
            modal.find('#edit_precio').val(button.data('precio'));
            modal.find('#edit_id_pub').val(button.data('id_pub'));
            modal.find('#edit_avance').val(button.data('avance'));
            modal.find('#edit_total_ventas').val(button.data('total_ventas'));
            modal.find('#edit_notas').val(button.data('notas'));
            modal.find('#edit_contrato').val(button.data('contrato'));
         });
      });
      </script>
      <script>
      $(document).ready(function() {
         setTimeout(function() {
            $('.loader_bg').fadeOut('slow');
         }, 1500);
      });
      </script>
   </body>
</html>