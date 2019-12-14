<?php
namespace OCFram;

abstract class BackController extends ApplicationComponent
{
  protected $action = '';
  protected $module = '';
  protected $page = null;
  protected $view = '';
  protected $managers = null;

  public function __construct(Application $app, $module, $action)
  {
    parent::__construct($app);

    $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    $this->page = new Page($app);

    $this->setModule($module);
    $this->setAction($action);
    $this->setView($action);
  }

  public function execute()
  {
    $method = 'execute'.ucfirst($this->action);

    if (!is_callable([$this, $method]))
    {
      throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
    }

    // CACHE : Système de mise en cache de la vue
    // On défini le nome du fichier de la vue
    $this->app->setFileName = $this->app->cache()->defineFileName(__DIR__.'/../../tmp/cache/views/', $this->app->name(), $this->module, $this->view);

    if(!$this->app->cache()->FileExist($this->app->fileName) || !$this->app->cache()->fileIsExpired($this->app->fileName)) // Si la vue n'est pas créé ou le tps est dépassé, elle est créée.
    {
      echo 'backController ligne '. __LINE__ ;
      // Création fichier
      $this->$method($this->app->httpRequest());
    }
    else
    {
      echo 'backController ligne '. __LINE__ ;
      //lecture du fichier
      $this->httpResponse->send($this->app->fileName);
    }
  }

  public function page()
  {
    return $this->page;
  }

  public function module()
  {
    return $this->module;
  }

  public function setModule($module)
  {
    if (!is_string($module) || empty($module))
    {
      throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
    }

    $this->module = $module;
  }

  public function setAction($action)
  {
    if (!is_string($action) || empty($action))
    {
      throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
    }

    $this->action = $action;
  }

  public function setView($view)
  {
    if (!is_string($view) || empty($view))
    {
      throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
    }

    $this->view = $view;

    $this->page->setContentFile(__DIR__.'/../../App/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
  }
}
