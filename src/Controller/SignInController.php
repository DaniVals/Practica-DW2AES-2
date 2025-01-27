<?php
namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function signIn(UserPasswordHasherInterface $passwordHasher, $nameTag, $email, $passwd): Response
    {
        $user = new User();
        $plaintextPassword = $passwd;

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        // ...
    }

    public function delete(UserPasswordHasherInterface $passwordHasher, UserInterface $user, $passwd): void
    {
        // ... e.g. get the password from a "confirm deletion" dialog
        $plaintextPassword = $passwd;

        if (!$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
            throw new AccessDeniedHttpException();
        }
    }
}
