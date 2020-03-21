<div class="back-usersShow-contenu">
  <div class="centragePage">
    <div class="entete-admin-showPosts">
    <h2 class="entete-admin-posts">Liste des membres</h2>
  </div>
      <div class="table-admin-show table-responsive-sm">
        <table class="table">
          <tr>
            <th>Login</th>
            <th>email</th>
            <th>Date d'ajout</th>
            <th>Rôle</th>
            <th>Actions</th>
          </tr>

          <?php
          foreach ($listeUsers as $users)
          { ?>
            <tr>
              <td>
                <?= htmlentities($users->login()); ?>
              </td>
              <td>
                <?= htmlentities($users->email()); ?>
              </td>
              <td>
                <?= $users->create_date()->format('d/m/Y à H\hi'); ?>
              </td>
              <td>
                <?= $users->role(); ?>
              </td>
              <td>
                <a href="users-delete-<?= $users->id(); ?>.html"><img src="/images/delete.png" alt="Supprimer"></a>
                <a href="users-upgrade-<?= $users->id(); ?>.html"><img src="/images/fleche2verte.png" alt="Upgrade"></a>
                <a href="users-downgrade-<?= $users->id(); ?>.html"><img src="/images/fleche2vertebas.png" alt="Downgrade"></a>
              </td>
            </tr>
            <?php }?>
        </table>
    </div>
  </div>
</div>
