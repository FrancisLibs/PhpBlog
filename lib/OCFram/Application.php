<?php
namespace OCFram;

abstract class Application
{
  protected $httpRequest;
  protected $httpResponse;
  protected $managers;
  protected $name;
  protected $user;
  protected $config;

  public function __construct()
  {
    $this->httpRequest = new HTTPRequest($this);
    $this->httpResponse = new HTTPResponse($this);
    $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    $this->user = new User($this);
    $this->config = new Config($this);


    $this->name = '';
  }

  public function getController()
  {
    $router = new Router;

    $xml = new \DOMDocument;
    $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

    $routes = $xml->getElementsByTagName('route');

    // On parcourt les routes du fichier XML.
    foreach ($routes as $route)
    {
      $vars = [];

      // On regarde si des variables sont présentes dans l'URL.
      if ($route->hasAttribute('vars'))
      {
        $vars = explode(',', $route->getAttribute('vars'));
      }

      // On ajoute la route au routeur.
      $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
    }


    try
    {
      // On récupère la route correspondante à l'URL.
      $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
    }
    catch (\RuntimeException $e)
    {
      if ($e->getCode() == Router::NO_ROUTE)
      {
        // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
        $this->httpResponse->redirect404();
      }
    }

    // On ajoute les variables de l'URL au tableau $_GET.
    $_GET = array_merge($_GET, $matchedRoute->vars());

    // Controle des droits d'accès
    if(empty($this->user()->getAttribute('users')))
    {
      $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
      return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }
    else
    {
      // Role de l'utilisateur
      $roleUsers = $this->user()->getAttribute('users')->role_id();

      // On récupère le manager du fichier des droits.
      $manager = $this->managers->getManagerOf('Rights');

      // et le rôle correspondant à la route
      $rights = $manager->getRights($this->name(), $matchedRoute->module(), $matchedRoute->action());

      $roleRoute = $rights->role();

      // On contrôle si le visiteur à le droit d'accéder à la resource
      if((int)$roleUsers >= (int)$roleRoute)
      {
        // Si oui, on instancie le contrôleur.
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';

        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
      }
      else // Sinon, on affiche un message d'erreur et on le renvoie en page d'accueil
      {
        $this->user()->setFlash('Vous n\'avez pas les droits requis pour accéder à cette fonction');
        $this->httpResponse()->redirect('/');
      }
    }
  }

  abstract public function run();

  public function httpRequest()
  {
    return $this->httpRequest;
  }

  public function httpResponse()
  {
    return $this->httpResponse;
  }

  public function name()
  {
    return $this->name;
  }

  public function config()
  {
    return $this->config;
  }

  public function user()
  {
    return $this->user;
  }
}