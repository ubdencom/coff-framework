<?php

namespace Coff\Framework\Auth;

use Coff\Framework\Http\Request;

class TokenGuard implements AuthInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function user()
    {
        $token = $this->getTokenFromRequest();
        if (!$token) {
            return null;
        }

        // TODO: Verify token and retrieve user
        // For now, we simulate a user if token exists
        return ['id' => 1, 'name' => 'API User', 'token' => $token];
    }

    public function id()
    {
        $user = $this->user();
        return $user['id'] ?? null;
    }

    public function login($user)
    {
        // Stateless auth doesn't persist login state on server
    }

    public function logout()
    {
        // Stateless auth doesn't persist logout state on server
    }

    protected function getTokenFromRequest(): ?string
    {
        $header = $this->request->headers['Authorization'] ?? '';
        if (strpos($header, 'Bearer ') === 0) {
            return substr($header, 7);
        }
        return null;
    }
}

