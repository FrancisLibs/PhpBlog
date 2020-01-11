<?php
namespace OCFram;

abstract class Field
{
  use Hydrator;

  protected $errorMessage;
  protected $label;
  protected $name;
  protected $validators = [];
  protected $value;
  protected $divClass;
  protected $labelClass;
  protected $widgetClass;

  public function __construct(array $options = [])
  {
    if (!empty($options))
    {
      $this->hydrate($options);
    }
  }

  abstract public function buildWidget();

  public function isValid()
  {
    foreach ($this->validators as $validator)
    {
      if (!$validator->isValid($this->value))
      {
        $this->errorMessage = $validator->errorMessage();
        return false;
      }
    }

    return true;
  }

  public function setLabel($label)
  {
    if (is_string($label))
    {
      $this->label = $label;
    }
  }

  public function setLength($length)
  {
    $length = (int) $length;

    if ($length > 0)
    {
      $this->length = $length;
    }
  }

  public function setName($name)
  {
    if (is_string($name))
    {
      $this->name = $name;
    }
  }

  public function setValidators(array $validators)
  {
    foreach ($validators as $validator)
    {
      if ($validator instanceof Validator && !in_array($validator, $this->validators))
      {
        $this->validators[] = $validator;
      }
    }
  }

  public function setValue($value)
  {
    if (is_string($value))
    {
      $this->value = $value;
    }
  }

  public function setDivClass($divClass)
  {
    if (is_string($divClass))
    {
      $this->divClass = $divClass;
    }
  }

  public function setLabelClass($labelClass)
  {
    if (is_string($labelClass))
    {
      $this->labelClass = $labelClass;
    }
  }

  public function setWidgetClass($widgetClass)
  {
    if (is_string($widgetClass))
    {
      $this->widgetClass = $widgetClass;
    }
  }

  public function label()
  {
    return $this->label;
  }

  public function length()
  {
    return $this->length;
  }

  public function name()
  {
    return $this->name;
  }

  public function validators()
  {
    return $this->validators;
  }

  public function value()
  {
    return $this->value;
  }

  public function divClass()
  {
    return $this->divClass;
  }

  public function labelClass()
  {
    return $this->labelClass;
  }

  public function widgetClass()
  {
    return $this->widgetClass;
  }
}
