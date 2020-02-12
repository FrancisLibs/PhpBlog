<?php
namespace OCFram;

class PasswordValidator extends Validator
{
  public function isValid($value)
  {
   return(preg_match(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#", $value));
  }
}

