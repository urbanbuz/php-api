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

    public function heartbeat()
    {
        $response = $this->apiLibrary->call('heartbeat');
        return json_decode(json_decode($response)->data)->heartbeat == "success";
    }

    public function login($email, $password)
    {
        $args = array(
            'email'=>$email,
            'password'=>MD5($password),
        );
        $response = $this->apiLibrary->call('login', $args);
        $userStatus = UserStatus::model()->fromJSON($response);
        return $userStatus;
    }

    public function signup($user)
    {
        $response = $this->apiLibrary->call('signup', $user);
        $userStatus = UserStatus::model()->fromJSON($response);
        return $userStatus;
    }

    public function update($source, $user)
    {
        $response = $this->apiLibrary->call('update', array_merge(array('source'=>$source), $user));
        $userStatus = UserStatus::model()->fromJSON($response);
        return $userStatus;
    }

    public function findUserByToken($token)
    {
        $response = $this->apiLibrary->call('findUserByToken', array('token'=>$token));
        $userStatus = UserStatus::model()->fromJSON($response);
        return $userStatus;
    }

    public function updateUserByToken($token, $user)
    {
        $response = $this->apiLibrary->call('updateUserByToken', array_merge(array('token'=>$token), $user));
        $userStatus = UserStatus::model()->fromJSON($response);
        return $userStatus;
    }
}
