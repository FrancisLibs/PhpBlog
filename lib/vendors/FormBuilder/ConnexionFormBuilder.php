<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class ContactFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'identifiant',
        'name' => 'login',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier votre identifiant),
        ],
       ]))
       ->add(new StringField([
        'label' => 'mot de passe',
        'name' => 'password',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (255 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier un mot de passe'),
        ],
       ]));
  }
}
