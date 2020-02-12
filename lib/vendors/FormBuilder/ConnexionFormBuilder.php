<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PasswordField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\EmailValidator;
use \OCFram\PasswordValidator;


class ConnexionFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'divClass'=>'form-group',
        'label' => 'pseudo : ',
        'name' => 'login',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le titre du post'),
        ],
       ]))
      ->add(new PasswordField([
        'divClass'=>'form-group',
        'label' => 'Mot de passe : ',
        'name' => 'password',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le chapo spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
          new PasswordValidator('Le mot de passe doit être composé d\'au moins 6 caractères, avec une minuscule, une majuscule, un chiffre, un caractère spécial'),
        ],
        ]));
  }
}
