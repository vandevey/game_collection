<?php


namespace App\Services;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordManager
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function change(&$user, $oldPassword, $newPassword): bool
    {
        if (
            isset($oldPassword)
            && $this->encoder->isPasswordValid($user, $oldPassword)
        ) {
            if (isset($newPasswordValue)) {
                $user->setPassword(
                    $this->encoder->encodePassword($user, $newPassword)
                );
            }

            return true;
        }

        return false;
    }

}