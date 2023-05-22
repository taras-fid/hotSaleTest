<?php

class UserRegistration
{
    private $name;
    private $surname;
    private $email;
    private $password;
    private $users;

    public function __construct($name, $surname, $email, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->users = [
            [
                'id' => 1,
                'email' => 'user1@example.com',
                'name' => 'Name 1',
                'surname' => 'Surname 1',
                'password' => 'password1'
            ],
            [
                'id' => 2,
                'email' => 'user2@example.com',
                'name' => 'Name 2',
                'surname' => 'Surname 2',
                'password' => 'password2'
            ]
        ];
    }

    public function validate()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($this->password !== $_POST['confirmPassword']) {
            return false;
        }

        foreach ($this->users as $user) {
            if ($user['email'] === $this->email) {
                return false;
            }
        }

        return true;
    }

    public function register()
    {
        $newUser = [
            'id' => count($this->users) + 1,
            'email' => $this->email,
            'name' => $this->name,
            'surname' => $this->surname,
            'password' => $this->password
        ];

        $this->users[] = $newUser;

        $logFile = 'log.txt';
        $logMessage = PHP_EOL . 'Email: ' . $this->email . ', Result: successful';
        file_put_contents($logFile, $logMessage, FILE_APPEND);

        return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $registration = new UserRegistration($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);

    if ($registration->validate() && $registration->register()) {
        echo 'success';
    }
    else {
        echo 'error';
    }
}
else {
    echo 'error';
}

?>