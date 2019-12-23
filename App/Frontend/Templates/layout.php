<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Clean Blog - Start Bootstrap Theme</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.html">My php blog<br />Francis Libs</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Accueil</a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="post.html">Posts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link float-right btn btn-outline-primary" href="contact.html">Connexion</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Fin navigation  -->

    <header class="masthead" style="background-image: url('images/plageGuadeloupe.jpg')">
      <div class="overlay"></div><!-- Voile sur le background -->
      <div class="container">
        <?php
        if($accueil){  ?>
        <div class="row">
          <div class="col-lg-7 col-md-10 ligne-titre">
            <div class="site-heading">
              <h1>La Webuzine</h1>
              <span class="subheading">Le trait d'union entre votre immagination et le Web</span>
            </div>
          </div>
          <div class="col-lg-5 post-box">
            <div class="site-heading">
              <span class="subheading">
                <h5>Derniers posts :</h5>
                <?= $content ?>
              </span>
            </div>
          </div>
        </div>
      <?php }
      else {
      }?>
    </header>



    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>


     <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>




