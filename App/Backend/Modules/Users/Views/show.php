<p style="text-align: center">Il y a actuellement <?= $nbUsers ?> utilisateurs. En voici la liste :</p>

<table>
  <tr>
    <th>Login</th>
    <th>email</th>
    <th>Date d'ajout</th>
    <th>Status</th>
    <th>Rôle</th>
    <th>Actions</th>
  </tr>

  <?php
  foreach ($listeUsers as $users)
  {
    echo '
    <tr>
      <td>
        ', $users['login'], '
      </td>
      <td>
        ', $users['email'], '
      </td>
      <td>
        ', $users['create_date']->format('d/m/Y à H\hi'), '
      </td>
      <td>
        ', $users['status'],'
      </td>
      <td>
        ', $users['role'],'
      </td>

      <td>
        <a href="users-delete-',    $users['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a>
        <a href="upgrade-',         $users['id'], '.html"><img src="/images/fleche2verte.png" alt="Upgrade"</a>
      </td>
    </tr>
    ', "\n";
  }
?>
</table>