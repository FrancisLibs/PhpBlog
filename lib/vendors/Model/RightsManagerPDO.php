<?php
namespace Model;

use \Entity\Rights;

class RightsManagerPDO extends RightsManager
{
  public function getRights($app, $module, $action)
  {
    $requete = $this->dao->prepare('SELECT app, module, action, role FROM rights WHERE ');
    $requete->bindValue(':app',     $app,     \PDO::PARAM_STR);
    $requete->bindValue(':module',  $module,  \PDO::PARAM_STR);
    $requete->bindValue(':action',  $action,  \PDO::PARAM_STR);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Rights');
 
    if ($rights = $requete->fetch())
    {
      return $rights;
    }
    return null;
  }
}
