<?php

include 'config.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $nombre = $_POST['nombre'];
   $correo = $_POST['correo'];
   $asunto = $_POST['asunto'];
   $comentario = $_POST['comentario'];

   $stmt = $pdo->prepare('INSERT INTO contactos (nombre, correo, asunto, comentario) VALUES (:nombre, :correo, :asunto, :comentario)');
   $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':asunto' => $asunto, ':comentario' => $comentario]);

   $mensaje = "Su mensaje ha sido enviado de manera exitosa!";
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
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
   <body class="main-layout contact-page">
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
                                 <li><a href="books.php">Nuestros libros</a></li>
                                 <li><a href="autores.php">Autores</a></li>
                                 <li class="active"> <a href="contact.php">Contáctenos</a></li>
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
                     <h2>Contáctenos</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Contact -->
      <div class="Contact">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <?php if ($mensaje): ?>
                     <div class="alert alert-info">
                        <?php echo $mensaje; ?>
                     </div>
                  <?php endif; ?>
                  <form action="contact.php" method="post">
                     <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                           <input class="form-control" placeholder="Nombre" name="nombre" type="text" required>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                           <input class="form-control" placeholder="Email" name="correo" type="Email" required>
                        </div>
                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                           <input class="form-control" placeholder="Asunto" name="asunto" type="text" required>
                        </div>
                        <div class="col-sm-12">
                           <textarea class="textarea" name="comentario" placeholder="Comentario" required></textarea>
                        </div>
                        <div class="col-sm-12">
                           <button class="send-btn" type="submit">Enviar</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- end Contact -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>