<div class="back-usersShow-contenu">
  <div class="centragePage">
     <div class="entete-admin-showPosts">
    <h2 class="entete-admin-posts">Liste des administrateurs</h2>
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

        <?php foreach ($listeUsers as $users) { ?>
          <tr>
            <td>
              <?= htmlspecialchars($users->login()) ?>
            </td>
            <td>
              <?= htmlspecialchars($users->email()) ?>
            </td>
            <td>
              <?= htmlspecialchars($users->create_date()->format('d/m/Y à H\hi')) ?>
            </td>
            <td>
              <?= htmlspecialchars($users->role()) ?>
            </td>
            <td>
              <a href="users-adminDelete-<?= $users->id() ?>.html"><img src="/images/delete.png" alt="Supprimer"></a>
              <a href="admin-upgrade-<?= $users->id() ?>.html"><img src="/images/fleche2verte.png" alt="Upgrade"></a>
            </td>
          </tr>
          <?php }?>
      </table>
    </div>
  </div>
</div>
