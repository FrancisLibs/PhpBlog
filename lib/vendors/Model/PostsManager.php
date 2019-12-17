<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Posts;

abstract class PostsManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un post.
   * @param $post Posts Le post à ajouter
   * @return void
   */
  abstract protected function add(Posts $post);

  /**
   * Méthode permettant d'enregistrer une post.
   * @param $post Posts le post à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(Posts $post)
  {
    if ($post->isValid())
    {
      $post->isNew() ? $this->add($post) : $this->modify($post);
    }
    else
    {
      throw new \RuntimeException('Le post doit être validé pour être enregistré');
    }
  }

  /**
   * Méthode renvoyant le nombre de posts total.
   * @return int
   */
  abstract public function count();

  /**
   * Méthode permettant de supprimer un post.
   * @param $id int L'identifiant du post à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de posts demandés.
   * @param $debut int Le premier post à sélectionner
   * @param $limite int Le nombre de posts à sélectionner
   * @return array La liste des posts. Chaque entrée est une instance de Posts.
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode retournant un post précis.
   * @param $id int L'identifiant du post à récupérer
   * @return Posts Le post demandé
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier un post.
   * @param $posts Post le post à modifier
   * @return void
   */
  abstract protected function modify(Posts $post);
}
