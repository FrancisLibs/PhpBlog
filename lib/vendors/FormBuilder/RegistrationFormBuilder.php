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
        'divClass'=>'form-group',
        'label' => 'pseudo : ',
        'name' => 'login',
        'labelClass' => 'labelLogin col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetLogin form-control input-sm',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier votre nom'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>'form-group',
        'label' => 'email : ',
        'name' => 'email',
        'labelClass' => 'labelEmail col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetEmail form-control input-sm',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('L\'email spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'email'),
        ],
        ]))
      ->add(new PasswordField([
        'divClass'=>'form-group',
        'label' => 'mdp : ',
        'name' => 'password',
        'labelClass' => 'labelMdp col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetMdp form-control input-sm',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
        ],
        ]))
      ->add(new PasswordField([
        'divClass'=>'form-group',
        'label' => 'confirmation : ',
        'name' => 'verifyPassword',
        'labelClass' => 'labelConfirm col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetConfirm form-control input-sm',
        'maxLength' => 50,
        'maxLength' => 50,
        'validators' => [
          new MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier le mot de passe'),
        ],
        ]));
  }
}
