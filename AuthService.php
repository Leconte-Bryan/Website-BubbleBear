<?php
class User
{
    public string $username;
    public string $email;
    public string $password;

    public function __construct(string $username, string $password, string $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
}

class AuthService
{
    private array $users; // Array simulating database (table "users")

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    // Username length between 7 - 14
    public function validUsername(string $username): bool
    {
        if (strlen($username) >= 7  && strlen($username) <= 14) {
            return true;
        }
        return false;
    }

    // Check if already an entry, if not, can register -> return true
    public function register(string $username, string $password, string $email): bool
    {
        foreach ($this->users as $user) {
            if ($user->username === $username && $user->email === $email) {
                return false; // already used
            }
        }
        return true;
    }

    // Check if correspond to the entry in the database
    public function login(string $username, string $password, string $email): bool
    {
        foreach ($this->users as $user) {
            if ($user->username === $username && $user->password === $password && $user->email === $email) {
                return true; // login réussi
            }
        }
        return false; // login échoué
    }
}
