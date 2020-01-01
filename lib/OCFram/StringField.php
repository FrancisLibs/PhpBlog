<?php
namespace OCFram;

class StringField extends Field
{
  protected $maxLength;

  public function buildWidget()
  {
    $widget = '<div class="'.$this->divClassName.'">';

    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }

    $widget .= '<label ';

    if(!empty($this->labelClass))
    {
      $widget .= ' class="'.$this->labelClass.'" ';
    }

    $widget .= 'for="'.$this->name.'">'.$this->label.'</label><input ';

    if(!empty($this->widgetClass))
    {
      $widget .= ' class="'.$this->widgetClass.'" ';
    }

    $widget .= 'type="text" id="'.$this->name.'" name="'.$this->name.'"';

    if (!empty($this->value))
    {
      $widget .= ' value="'.htmlspecialchars($this->value).'"';
    }

    if (!empty($this->maxLength))
    {
      $widget .= ' maxlength="'.$this->maxLength.'"';
    }
    //var_dump($widget .= ' /></div>');
    return $widget .= ' /></div>';
  }

  public function setMaxLength($maxLength)
  {
    $maxLength = (int) $maxLength;

    if ($maxLength > 0)
    {
      $this->maxLength = $maxLength;
    }
    else
    {
      throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
    }
  }
}
