<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;


class ContactFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'divClass'    => 'form-group',
        'label'       => 'Nom : ',
        'name'        => 'lastName',
        'labelClass'  => 'labelNom col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetNom form-control input-sm',
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
        'labelClass' =>   'labelPrenom col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' =>  'widgetPrenom form-control input-sm',
        'maxLength' =>100,
        'validators' => [
          new MaxLengthValidator('Le prénom spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'auteur du message'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>  'form-group',
        'label' =>        'Email : ',
        'name' =>         'email',
        'labelClass' =>   'labelEmail col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' =>  'widgetEmail form-control input-sm',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('L\'email spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier votre adresse email'),
        ],
       ]))
       ->add(new TextField([
        'divClass'=>  'form-group',
        'label' =>        'Message : ',
        'name' =>         'message',
        'labelClass' =>   'labelMessage col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' =>  'widgetMessage form-control input-sm',
        'rows' =>3,
        'cols' => 40,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du message'),
        ],
       ]));
  }
}
