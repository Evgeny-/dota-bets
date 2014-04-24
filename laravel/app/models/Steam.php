<?php


class Steam {

    protected $key = null;

    protected $url = null;


    public function __construct()
    {
        $this->key = '39C41AE164BD25188A5A47AB79560AE8';
        $this->url = url('/');
    }

    public function getUserInfo ($steamid)
    {
        $slf = "http://steamcommunity.com/profiles/{$steamid}/?xml=1";
        $url = simplexml_load_file($slf);

        return $url;
    }

    public function signIn ()
    {
        require_once 'Openid.php';

        $openid = new LightOpenID($this->url);

        if(!$openid->mode)
        {
            $openid->identity = 'http://steamcommunity.com/openid';

            header('Location: ' . $openid->authUrl());
            die();

        }
        elseif($openid->mode == 'cancel')
        {
            print ('User has canceled authentication!');
        }
        else
        {
            if($openid->validate())
            {
                preg_match("/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/", $openid->identity, $matches); // steamID: $matches[1]

                Session::put('login', $matches[1]);
            }
            else
            {
                print ('fail');
            }
        }
    }
}