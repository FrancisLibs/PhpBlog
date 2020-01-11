<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\PasswordField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;


class RegistrationFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form
      ->add(new StringField([
        'divClassName'=>'form-group',
        'label' => 'pseudo : ',
        'name' => 'login',
        'labelClass' => 'labelTitre col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetTitre form-control form-control-sm',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier votre nom'),
        ],
       ]))
      ->add(new StringField([
        'divClassName'=>'form-group',
        'label' => 'email : ',
        'name' => 'email',
        'labelClass' => 'labelChapo col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetChapo form-control form-control-sm',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('L\'email spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'email'),
        ],
        ]))
      ->add(new PasswordField([
        'divClassName'=>'form-group',
        'label' => 'mdp : ',
        'name' => 'password',
        'labelClass' => 'labelChapo col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetChapo form-control form-control-sm',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
        ],
        ]))
      ->add(new PasswordField([
        'divClassName'=>'form-group',
        'label' => 'confirmation : ',
        'name' => 'verifyPassword',
        'labelClass' => 'labelChapo col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetChapo form-control form-control-sm',
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
        ],
        ]));
  }
}
