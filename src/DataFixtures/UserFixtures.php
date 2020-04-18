<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Services\FixtureLoader;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserFixtures extends AbstractFixtures implements ReferenceAliasFixtureInterface
{

    protected $referenceKey = 'users';

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
//        $users = $this->fixtureLoader->load('users');
//
//        foreach ($users['data'] as $ref => $userData) {
//            /** @var User $user */
//            $user = $this->denormilazer->denormalize($userData, User::class);
//            $password = $this->encoder->encodePassword($user, $user->getPassword());
//            $user->setPassword($password);
//            $manager->persist($user);
//
//            $this->addReference($ref, $user);
//        }

        $user = new User();
        $user
            ->setEmail('john.doe@email.com')
            ->setPassword(
                $this->encoder->encodePassword($user, 'jo.doe')
            )
            ->setPseudo('John Doe')
            ->setIsDeleted(false)
            ->setRoles(['USER']);

        $manager->persist($user);
        $this->addReference('johndoe', $user);
        $manager->flush();
    }

    public function getReferenceAlias(): array
    {
        return [
            'author'
        ];
    }
}