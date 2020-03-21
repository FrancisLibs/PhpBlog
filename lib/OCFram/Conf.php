<?php

namespace OCFram;

class Conf
{
  private $settings = [];
  private static $_instance;

  public static function getInstance()
  {
    if(is_null(self::$_instance))
    {
      self::$_instance = new conf();
    }

    return self::$_instance;

  }

  public function __construct()
  {
    $this->settings = require dirname(__DIR__) . '../../conf/conf.php';
  }

  public function get($key)
  {
    if(!isset($this->settings[$key]))
    {
      return null;
    }
    else
    {
      return $this->settings[$key];
    }
  }

}
