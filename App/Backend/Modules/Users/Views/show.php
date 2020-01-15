<p style="text-align: center">Il y a actuellement <?= $nbUsers ?> utilisateurs. En voici la liste :</p>

<table>
  <tr>
    <th>Login</th>
    <th>email</th>
    <th>Date d'ajout</th>
    <th>Status</th>
    <th>Rôle</th>
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
        le ', $users['create_date']->format('d/m/Y à H\hi'), '
      </td>
      <td>
        ', $users['status'],'
      </td>
       </td> <td>
        ', $users['role'],'
      </td>

      <td>
        <a href="users-update-', $users['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a>
        <a href="users-delete-', $users['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a>
        <a href="users-show-', $users['id'], '.html"><img src="/images/select.png" alt="Supprimer"</a>
      </td>
    </tr>
    ', "\n";
  }
?>
</table>
