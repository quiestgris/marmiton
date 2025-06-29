<?php

namespace App\EntityListener;

use App\Entity\Admin;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(Admin $user): void
    {
        $this->encodePassword($user);
    }

    public function preUpdate(Admin $user): void
    {
        $this->encodePassword($user);
    }

    private function encodePassword(Admin $user): void
    {
        $plainPassword = $user->getPassword();
        if ($plainPassword === null) {
            return;
        }

        $hashed = $this->hasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashed);
    }
}
