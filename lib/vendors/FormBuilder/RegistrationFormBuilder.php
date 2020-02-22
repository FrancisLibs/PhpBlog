<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PasswordField;
use \OCFram\EmailField;
use \OCFram\HiddenField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\EmailValidator;
use \OCFram\PasswordValidator;

class RegistrationFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form
      ->add(new StringField([
        'divClass'=>'form-group',
        'label' => 'pseudo : ',
        'name' => 'login',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier votre nom'),
        ],
       ]))
      ->add(new EmailField([
        'divClass'=>'form-group',
        'label' => 'email : ',
        'name' => 'email',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('L\'email spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'email'),
          new EmailValidator('L\'adresse mail n\'a pas le bon format'),
        ],
        ]))
      ->add(new PasswordField([
        'divClass'=>'form-group',
        'label' => 'mdp : ',
        'name' => 'password',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe.'),
          new PasswordValidator('Le mot de passe doit être composé d\'au moins 6 caractères, avec une minuscule, une majuscule, un chiffre, un caractère spécial'),
        ],
        ]))
      ->add(new PasswordField([
        'divClass'=>'form-group',
        'label' => 'confirmation : ',
        'name' => 'verifyPassword',
        'labelClass' => 'label col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widget form-control input-sm w-50',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
          new PasswordValidator('Le mot de passe doit être composé d\'au moins 6 caractères, avec une minuscule, une majuscule, un chiffre, un caractère spécial'),
        ],
        ]))
      ->add(new HiddenField([
        'name' => 'formToken'
       ]));;
  }
}
