<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $users = array(
            'administrator' => 'r4l535*y980g9v1O',
            'client' => '8Li&AnxT3EC%',
        );
        if (!isset($users[$this->username])) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($users[$this->username] !== $this->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->setState('roles', "admin");
        }
        return !$this->errorCode;
    }
}
