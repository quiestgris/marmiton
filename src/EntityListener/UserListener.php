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
public function prePersist(Admin $user)
{
    $this ->encodePassword($user);

}
 public function preUpdate(Admin $user)
 {
    $this->encodePassword($user);

 }

/**
* Encode password based on plain password
*
*
*@param User $user 
*@return void
*/
public function encodePassword(Admin $user)
{
    if($user->getPlainPassword()===null){
        return;
    }
    $user->setPassword(
        $this->hasher->hashPassword(
            $user,
            $user->getPlainPAssword()
        )
        );

    }
}