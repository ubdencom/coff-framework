<?php

namespace Coff\Framework\Auth;

interface AuthInterface
{
    public function check(): bool;
    public function user();
    public function id();
    public function login($user);
    public function logout();
}

