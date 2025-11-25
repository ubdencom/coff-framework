<?php

namespace Coff\Framework\Auth;

class SessionGuard implements AuthInterface
{
    protected string $sessionKey = 'user';

    public function check(): bool
    {
        return isset($_SESSION[$this->sessionKey]);
    }

    public function user()
    {
        return $_SESSION[$this->sessionKey] ?? null;
    }

    public function id()
    {
        $user = $this->user();
        // Assuming user is array or object with id property
        if (is_array($user)) {
            return $user['id'] ?? null;
        }
        return $user->id ?? null;
    }

    public function login($user)
    {
        $_SESSION[$this->sessionKey] = $user;
    }

    public function logout()
    {
        unset($_SESSION[$this->sessionKey]);
    }
}

