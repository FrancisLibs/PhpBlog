<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\HiddenField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class PostFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'divClassName'=>'form-group',
        'label' => 'titre',
        'name' => 'title',
        'labelClass' => 'labelTitre col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetTitre form-control form-control-sm',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre du post'),
        ],
       ]))
      ->add(new StringField([
        'divClassName'=>'form-group',
        'label' => 'chapo',
        'name' => 'chapo',
        'labelClass' => 'labelChapo col-lg-2 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetChapo form-control form-control-sm',
        'maxLength' => 255,
        'validators' => [
          new MaxLengthValidator('Le chapo spécifié est trop long (255 caractères maximum)', 255),
          new NotNullValidator('Merci de spécifier le chapo du post'),
        ],
        ]))
      ->add(new TextField([
        'divClassName'=>'form-group',
        'label' => 'contenu',
        'name' => 'contenu',
        'labelClass' => 'labelMessage col-sm-3 col-form-label col-form-label-sm',
        'widgetClass' => 'widgetMessage form-control form-control-sm',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du post'),
        ],
       ]))
      ->add(new HiddenField([
        'name' => 'autor_name'
       ]))
      ->add(new HiddenField([
        'name' => 'user_id'
       ]));

  }
}
