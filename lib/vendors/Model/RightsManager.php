<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Rights;

abstract class RightsManager extends Manager
{
  /**
   * Méthode permettant d'obtenir le rôle alloué à la route demandée.
   * @param $app paramètre : nom de l'application
   * @param $module paramètre : nom du module
   * @param $action paramètre : nom de l'action
   * @return rights
   */
  abstract public function getRights($app, $module, $action);
}
