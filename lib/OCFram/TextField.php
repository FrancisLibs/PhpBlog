<?php
namespace OCFram;

class TextField extends Field
{
  protected $cols;
  protected $rows;

  public function buildWidget()
  {
    $widget = '';

    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }

    $widget .= '<div';

    if (!empty($this->divClass))
    {
      $widget .= ' class="'.$this->divClass.'"';
    }

    $widget .= '><label';

    if (!empty($this->labelClass))
    {
      $widget .= ' class="'.$this->labelClass.'"';
    }

    $widget .= '>'.$this->label.'</label><textarea';

    if (!empty($this->widgetClass))
    {
      $widget .= ' class="'.$this->widgetClass.'"';
    }
     $widget .= ' name="'.$this->name.'"';

    if (!empty($this->cols))
    {
      $widget .= ' cols="'.$this->cols.'"';
    }

    if (!empty($this->rows))
    {
      $widget .= ' rows="'.$this->rows.'"';
    }

    $widget .= '>';

    if (!empty($this->value))
    {
      $widget .= $this->value; //  $widget .= htmlspecialchars($this->value);
    }

    return $widget.'</textarea></div>';
  }

  public function setCols($cols)
  {
    $cols = (int) $cols;

    if ($cols > 0)
    {
      $this->cols = $cols;
    }
  }

  public function setRows($rows)
  {
    $rows = (int) $rows;

    if ($rows > 0)
    {
      $this->rows = $rows;
    }
  }
}
