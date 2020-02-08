<?php
namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\HiddenField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \Entity\Post;

class PostFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'divClass'=>'form-group',
        'label' => 'titre',
        'name' => 'title',
        'labelClass' => 'labelTitre col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetTitre form-control input-sm w-50',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre du post'),
        ],
       ]))
      ->add(new StringField([
        'divClass'=>'form-group',
        'label' => 'chapo',
        'name' => 'chapo',
        'labelClass' => 'labelChapo col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetChapo form-control input-sm w-50',
        'maxLength' => 255,
        'validators' => [
          new MaxLengthValidator('Le chapo spécifié est trop long (255 caractères maximum)', 255),
          new NotNullValidator('Merci de spécifier le chapo du post'),
        ],
        ]))
      ->add(new TextField([
        'divClass'=>'form-group',
        'label' => 'contenu',
        'name' => 'contenu',
        'labelClass' => 'labelContenu col-4 col-form-label col-form-label-sm inputsm',
        'widgetClass' => 'widgetContenu form-control input-sm w-50',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu du post'),
        ],
       ]))
      ->add(new HiddenField([
        'name' => 'users_id'
       ]));
  }
}
