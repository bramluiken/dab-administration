<?php

namespace App\Forms;

use App\Abstracts\FormAbstract;

class LoginForm extends FormAbstract {
    protected function defineFields() {
        $this->addField('text', 'username', 'Username', ['placeholder' => 'Enter your username']);
        $this->addField('password', 'password', 'Password', ['placeholder' => 'Enter your password']);
    }

    public function handle($data) {
        if ($this->validate($data)) {
            $sanitizedData = $this->sanitize($data);
            return $this->checkCredentials($sanitizedData);
        }
        return false;
    }

    private function checkCredentials($data) {
        // Use a prepared statement to safely query the user by username.
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $data['username'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // If a user is found and the password matches the hash, return the user data.
        if ($user && password_verify($data['password'], $user['password'])) {
            // Optionally remove the password hash before returning user data.
            unset($user['password']);
            return $user;
        }
        // Login failed.
        return false;
    }
}