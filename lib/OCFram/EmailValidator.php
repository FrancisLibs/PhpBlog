<?php
namespace OCFram;

class EmailValidator extends Validator
{
  public function isValid($value)
  {
   return(preg_match(" /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ", $value));
  }
}