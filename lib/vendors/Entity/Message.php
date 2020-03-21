<?php
namespace Entity;

use \OCFram\Entity;

class Message extends Entity
{
  protected $firstName,
            $lastName,
            $email,
            $message,
            $formToken;

   // SETTERS //

  public function setFirstName($firstName)
  {
    if (is_string($firstName) || !empty($firstName))
    {
      $this->firstName = $firstName;
    }
  }

  public function setLastName($lastName)
  {
    if (is_string($lastName) || !empty($lastName))
    {
      $this->lastName = $lastName;
    }
  }

  public function setEmail($email)
  {
    if (is_string($email) || !empty($email))
    {
      $this->email = $email;
    }
  }

  public function setMessage($message)
  {
    if (is_string($message) || !empty($message))
    {
      $this->message = $message;
    }
  }

  public function setEdition_date(\DateTime $edition_date)
  {
    $this->edition_date = $edition_date;
  }

  public function setFormToken($formToken)
  {
    $this->formToken = $formToken;
  }


  // GETTERS //

  public function firstName()
  {
    return $this->firstName;
  }

  public function lastName()
  {
    return $this->lastName;
  }

  public function email()
  {
    return $this->email;
  }

  public function message()
  {
    return $this->message;
  }

  public function edition_date()
  {
    return $this->edition_date;
  }

  public function formToken()
  {
    return $this->formToken;
  }
}
