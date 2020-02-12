<?php
  $usersRole=$user->getAttribute('users')->role_id();
?>

<div class="entete-index">
	<h2>Bienvenue dans l'administration de ce blog</h2>
</div>

<div class="backend-admin-liens">
    <a class="nav-link" href="/admin/posts.html">Gestion Articles</a>
    <a class="nav-link" href="/admin/users.html">Gestion utilisateurs</a>
    <?php 
    if($usersRole ==3){ ?>
      <a class="nav-link" href="/admin/admin.html">Gestion administrateurs</a>
    <?php } ?>
</div>
