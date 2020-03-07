<?php
namespace OCFram;

class CheckBoxField extends Field
{
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

    $widget .= '>'.$this->label.'</label><input type="checkbox"';

    if (!empty($this->widgetClass))
    {
      $widget .= ' class="'.$this->widgetClass.'"';
    }

    $widget.= ' name="'.$this->name.'"';

    if (!empty($this->value))
    {
      $widget .= ' value="'.htmlspecialchars($this->value).'"';
    }

    return $widget .= ' /></div>';
  }
}
