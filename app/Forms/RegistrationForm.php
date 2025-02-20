<?php

namespace App\Forms;

use App\Abstracts\FormAbstract;

class RegistrationForm extends FormAbstract {
    protected function defineFields() {
        // Adding a password field and a confirmation field for proper registration.
        $this->addField('text', 'username', 'Username', ['placeholder' => 'Enter your username']);
        $this->addField('email', 'email', 'Email', ['placeholder' => 'Enter your email']);
        $this->addField('password', 'password', 'Password', ['placeholder' => 'Enter your password']);
        $this->addField('password', 'confirm_password', 'Confirm Password', ['placeholder' => 'Confirm your password']);
    }

    public function handle($data) {
        if ($this->validate($data)) {
            $sanitizedData = $this->sanitize($data);

            // Check that password and confirmation match.
            if ($sanitizedData['password'] !== $sanitizedData['confirm_password']) {
                throw new \Exception("Passwords do not match.");
            }

            // Check if the username or email already exists.
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $stmt->execute([
                ':username' => $sanitizedData['username'],
                ':email'    => $sanitizedData['email'],
            ]);
            if ($stmt->fetchColumn() > 0) {
                throw new \Exception("Username or email already exists.");
            }

            // Hash the password before storing it.
            $hashedPassword = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);

            // Insert the new user record using a prepared statement.
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password, country)
                VALUES (:username, :email, :password, :country)
            ");
            $success = $stmt->execute([
                ':username' => $sanitizedData['username'],
                ':email'    => $sanitizedData['email'],
                ':password' => $hashedPassword,
                ':country'  => $sanitizedData['country'],
            ]);

            if ($success) {
                // Optionally, return the new user's ID.
                return $this->db->lastInsertId();
            }
            return false;
        }
        return false;
    }
}