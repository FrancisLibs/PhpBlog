<?php
namespace Entity;

use \OCFram\Entity;

class Rights extends Entity
{
  protected $id,
            $app,
            $module,
            $action,
            $role,
            $formToken;

  const APP_INVALIDE = 1;
  const MODULE_INVALIDE = 2;
  const ACTION_INVALIDE = 3;
  const ROLE_INVALIDE = 4;

  // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setApp($app)
  {
    if (!is_string($app) || empty($app))
    {
      $this->erreurs[] = self::APP_INVALIDE;
    }
    $this->app = $app;
  }

  public function setModule($module)
  {
    if (!is_string($module) || empty($module))
    {
      $this->erreurs[] = self::MODULE_INVALIDE;
    }

    $this->module = $module;
  }

  public function setAction($action)
  {
    if (!is_string($action) || empty($action))
    {
      $this->erreurs[] = self::ACTION_INVALIDE;
    }

    $this->action = $action;
  }

  public function setRole($role)
  {
    if (is_int($role) || empty($role))
    {
      $this->erreurs[] = self::ROLE_INVALIDE;
    }
    else
    {
      if (!preg_match ( "^[123]$" , $role ) )
      {
        $this->erreurs[] = self::ROLE_INVALIDE;
      }
    }
    $this->role = $role;
  }

  public function setFormToken($formToken)
  {
    $this->formToken = $formToken;
  }

  // GETTERS //

  public function id()
  {
    return $this->id;
  }

  public function app()
  {
    return $this->app;
  }

  public function module()
  {
    return $this->module;
  }

  public function action()
  {
    return $this->action;
  }

  public function role()
  {
    return $this->role;
  }

  public function formToken()
  {
    return $this->formToken;
  }
}
