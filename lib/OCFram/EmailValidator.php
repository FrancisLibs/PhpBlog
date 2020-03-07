<?php
namespace OCFram;

class EmailValidator extends Validator
{
  public function isValid($value)
  {
   return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value));
  }
}
