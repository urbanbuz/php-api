<?php

namespace UrbanBuz\API;

use UrbanBuz\API\models\UserStatus;

class UrbanBuz
{

    const DEFAULT_HOST = 'newapi.urbanbuz.com/api/v3';
    const DEFAULT_USESSL = false;

    protected $apiLibrary;

    public function __construct($apiKey, $apiSecret, $host = self::DEFAULT_HOST, $useSsl = self::DEFAULT_USESSL)
    {
        $this->apiLibrary = new ApiLibrary($host, $apiKey, $apiSecret, $useSsl);
    }

    public function login($email, $password)
    {
        $args = array(
            'email'=>$email,
            'password'=>MD5($password),
        );
        $response = $this->apiLibrary->call('login', $args);
        $userStatus = UserStatus::model()->fromJSON($response);
        var_dump($userStatus);
    }
}
