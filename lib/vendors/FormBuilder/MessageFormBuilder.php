<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\EmailField;
use \OCFram\HiddenField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\EmailValidator;


class MessageFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'divClass'    => 'form-group',
        'label'       => 'Nom : ',
        'name'        => 'lastName',
        'labelClass'  => 'label col-4 col-form-label col-form-label-sm inputsm font-weight-bold',
        'widgetClass' => 'widget form-control input-sm col-7',
        'maxLength'   =>100,
        'validators'  => [
          new MaxLengthValidator('Le nom spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'auteur du message'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>  'form-group',
        'label' =>        'Prénom : ',
        'name' =>         'firstName',
        'labelClass' =>   'label col-4 col-form-label col-form-label-sm inputsm font-weight-bold',
        'widgetClass' =>  'widget form-control input-sm col-7',
        'maxLength' =>100,
        'validators' => [
          new MaxLengthValidator('Le prénom spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'auteur du message'),
        ],
       ]))
      ->add(new EmailField([
        'divClass'=>  'form-group',
        'label' =>        'Email : ',
        'name' =>         'email',
        'labelClass' =>   'label col-4 col-form-label col-form-label-sm inputsm font-weight-bold',
        'widgetClass' =>  'widget form-control input-sm col-7',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('L\'email spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier votre adresse email'),
          new EmailValidator('Le format de l\'adresse mail n\'est pas correct'),
          
        ],
       ]))
       ->add(new TextField([
        'divClass'=>  'form-group',
        'label' =>        'Message : ',
        'name' =>         'message',
        'labelClass' =>   'label col-4 col-form-label col-form-label-sm inputsm font-weight-bold',
        'widgetClass' =>  'widget form-control input-sm col-7',
        'rows' =>3,
        'cols' => 40,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du message'),
        ],
       ]))
       ->add(new HiddenField([
        'name' => 'formToken'
       ]));
  }
}
