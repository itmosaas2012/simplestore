<?php

class User
{
    public $userID;
    public $login;
    public $password;
    public $email;
    public $name;
    public $surname;
    public $patronymic;
    public $tell;
    public $series;
    public $number;
    public $activated;
    public $sex;
    public $workplaceID;

    const SexMale = 1;
    const SexFemale = 0;

    public function validate() {

        $errors = array();

        if (strlen($this->login) < 3) {
            $errors['login'] = 'Login is too short.';
        }

        // bla bla bla need to verify every needed ivars

        return count($errors) ? $errors : null;
    }
}
