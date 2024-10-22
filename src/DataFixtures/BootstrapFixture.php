<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\StaffMember;
use App\Entity\Establishment;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BootstrapFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'testyui'
        );
        $user->setUsername('123456')
            ->setPassword($hashedPassword)
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($user);

        $staffMember = new StaffMember();
        $staffMember->setFirstname('Big')
            ->setLastname('Boss')
            ->setActionsPermitted([])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setUser($user);
        $manager->persist($staffMember);

        $establishment = new Establishment();
        $establishment->setName('Fancy Sushi')
            ->setAddress('123 rue du saké')
            ->setTimeLimitBeforeCancel(30) // 30 minutes
            ->setAvailableSeats(40)
            ->setOpen(true)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($establishment);

        $product = new Product();
        $product->setLabel('Sashimi')
                ->setDetails('Savoureux sashimi découpé par notre chef')
                ->setPrice(4.50)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($product);


        $manager->flush();
    }
}
