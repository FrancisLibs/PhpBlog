<?php
namespace OCFram;

class StringField extends Field
{
  protected $maxLength;


  public function buildWidget()
  {
    $widget = '';

    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }

    $widget .= '<div class="'.$this->divClass.'"><label for="'.$this->name.'"';

     if (!empty($this->labelClass))
    {
      $widget .= ' class="'.$this->labelClass.'"';
    }

    $widget .= '>'.$this->label.'</label><input type="text"';

    if (!empty($this->widgetClass))
    {
      $widget .= ' class="'.$this->widgetClass.'"';
    }

    $widget.= ' name="'.$this->name.'"';

    if (!empty($this->value))
    {
      $widget .= ' value="'.htmlentities($this->value).'"';
    }

    if (!empty($this->maxLength))
    {
      $widget .= ' maxlength="'.$this->maxLength.'"';
    }

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
