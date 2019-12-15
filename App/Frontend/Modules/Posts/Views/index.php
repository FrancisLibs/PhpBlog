<?php
foreach ($listePosts as $post)
{
?>
  <h2><a href="post-<?= $post['id'] ?>.html"><?= $post['titre'] ?></a></h2>
  <p><?= nl2br($post['contenu']) ?></p>
<?php
}
