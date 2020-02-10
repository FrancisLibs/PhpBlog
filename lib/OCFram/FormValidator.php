<?php
namespace OCFram;

class FormHandler
{
  protected $form;
  protected $request;

  public function __construct(Form $form, HTTPRequest $request)
  {
    $this->setForm($form);
    $this->setRequest($request);
  }

  public function process()
  {
    if($this->request->method() == 'POST' && $this->form->isValid())
    {
      return true;
    }

    return false;
  }

  public function setForm(Form $form)
  {
    $this->form = $form;
  }

  public function setRequest(HTTPRequest $request)
  {
    $this->request = $request;
  }
}
