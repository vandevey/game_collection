<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Services\FixtureLoader;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserFixtures extends AbstractFixtures
{

    /**
     * File fixture name
     *
     * @var string
     */
    const RESOURCE_NAME = 'users';

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, FixtureLoader $fixtureLoader, DenormalizerInterface $denormalizer)
    {
        $this->encoder = $encoder;
        parent::__construct($fixtureLoader, $denormalizer);
    }

    /**
     * @inheritDoc
     */
    function load(ObjectManager $manager)
    {
        $users = $this->fixtureLoader->load(self::RESOURCE_NAME);

        foreach ($users['data'] as $ref => $userData) {
            /** @var User $user */
            $user = $this->denormilazer->denormalize($userData, User::class);
            $password = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);

            $this->addReference($ref, $user);
        }

        $manager->flush();
    }
}