<?php
foreach ($listePosts as $post)
{
?>
  <h2><a href="post-<?= $post['id'] ?>.html"><?= $post['title'] ?></a></h2>
  <p><?= nl2br($post['contents']) ?></p>
<?php
}
