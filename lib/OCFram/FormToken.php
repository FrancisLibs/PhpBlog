<?php
namespace OCFram;

class FormToken
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function setFormToken()
    {
        // Produit un token,
        //le sauvegarde en session et le retourne
        //pour l'inclusion en champ caché du formulaire
        $formtoken = bin2hex(random_bytes(20));
        $this->user->setSession('formToken', $formtoken);

        return $formtoken;
    }

    public function checkFormToken($request)
    {
        if($this->user->sessionExist('formToken') && $request->postExists('formToken'))
        {
            if($this->user->getAttribute('formToken') == $request->postData('formToken'))
            {
                return true;
            }
        }

        return false;
    }




}
