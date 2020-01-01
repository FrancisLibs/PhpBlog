<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class CommentFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'author',
        'name' => 'author',
        'maxLength' => 20,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (20 caractères maximum)', 20),
          new NotNullValidator('Merci de spécifier l\'auteur du post'),
        ],
        'className' => 'auteur',
       ]))
       ->add(new StringField([
        'label' => 'title',
        'name' => 'title',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre du post'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'chapo',
        'name' => 'chapo',
        'maxLength' => 255,
        'validators' => [
          new MaxLengthValidator('Le chapo spécifié est trop long (255 caractères maximum)', 255),
          new NotNullValidator('Merci de spécifier le chapo du post'),
        ],
       ->add(new TextField([
        'label' => 'contents',
        'name' => 'contents',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du post'),
        ],
       ]));
  }
}
