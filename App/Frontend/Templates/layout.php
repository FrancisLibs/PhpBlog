<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $title ?></title>
  <meta name="description" content="Mon premier blog en PHP" />

  <!-- Css files -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body>
  <header>
    <!-- Navigation -->
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/">Francis Libs</a>

        <!-- Collapse button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto navbar-default">
            <?php 
              if(isset($_SESSION['users']) && ($_SESSION['users']->role_id() >= 2)) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="/admin/">Administration</a>
                </li>
            <?php } ?>

            <li class="nav-item">
              <a class="nav-link" href="/">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="posts.html">Articles</a>
            </li>
            <?php if(!isset($_SESSION['users'])){ ?>
            <li class="nav-item">
              <a class="btn btn-sm" id="bonjour" href="connect.html">Bonjour, identifiez-vous</a>
            </li>
            <li class="nav-item">
              <a href="register.html" id="nouveau" class="btn btn-primary btn-sm" role="button" aria-disabled="true">Nouveau ? Commencez ici.</a>
            </li>
            <?php }
              else
              {
                $users = $_SESSION['users'] ?>
                <li class="nav-item">
                  <span class="navbar-brand">Bonjour <?= $users->login() ?></span>
                </li>
                <li class="nav-item">
                  <a href="deconnect.html" id="deconnect" class="btn btn-primary btn-sm" role="button" aria-disabled="true">Déconnexion</a>
                </li>
              <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
    <hr/>
  </header>
  <!-- Fin de navigation -->

  <main class= "contenu-principal">
    <?= $content ?> 
  </main>

  <!-- Footer -->
  <footer>
    <hr/>
    <div class="footer container-fluid">
      <div class="row ligneLiens">
        <div class="icones col-xs-12 col-sm-3 col-md-2 col-lg-2 offset-sm-4 offset-md-5">
          <a btn-linkedin #007BB6 href="https://www.linkedin.com/in/francis-libs-480a68150"><img src="/images/linkedin.jpg" alt="linkedin"></a>
          <a btn-github #444444 href="https://github.com/FrancisLibs/phpBlog"><img src="/images/github.png" alt="github"></a>
        </div>
        <div class="liens col-xs-12 col-sm-4 col-md-3 col-lg-2 offset-md-2 offset-sm-1">
          <a class="lienCV" href="/" role="button">Mon parcours</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>




