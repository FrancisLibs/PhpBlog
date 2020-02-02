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
        'labelClass'  => 'labelNom col-lg-3 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetNom form-control form-control-sm',
        'maxLength'   =>100,
        'validators'  => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'auteur du message'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>  'form-group',
        'label' =>        'Prénom : ',
        'name' =>         'firstName',
        'labelClass' =>   'labelPrenom col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' =>  'widgetPrenom form-control form-control-sm',
        'maxLength' =>100,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier l\'auteur du message'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>  'form-group',
        'label' =>        'Email : ',
        'name' =>         'email',
        'labelClass' =>   'labelEmail col-sm-2 col-form-label col-form-label-sm',
        'widgetClass' =>  'widgetEmail form-control form-control-sm',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier votre adresse email'),
        ],
       ]))
       ->add(new TextField([
        'divClass'=>  'form-group',
        'label' =>        'Message : ',
        'name' =>         'message',
        'labelClass' =>   'labelMessage col-sm-3 col-form-label col-form-label-sm',
        'widgetClass' =>  'widgetMessage form-control form-control-sm',
        'rows' =>3,
        'cols' => 40,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du message'),
        ],
       ]));
  }
}
