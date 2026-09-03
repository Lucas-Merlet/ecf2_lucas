<?php

namespace App\DataFixtures;

use App\Entity\Intern;
use App\Entity\Reason;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // --- The 4 absence reasons ---
        $reasonLabels = ['Maladie', 'Sans motif', 'Absence légale', 'Accident du travail'];

        foreach ($reasonLabels as $label) {
            $reason = new Reason();
            $reason->setLabel($label);
            $manager->persist($reason);
        }

        // --- The 12 trainees ---
        $interns = [
            ['Adila', 'Kehlaoui', '0601020304'],
            ['Mohammed', 'Benerroua', '0611121314'],
            ['Ghislène', 'Bellia', '0621222324'],
            ['Aurèle', 'Camps', '0631323334'],
            ['Nelly', 'Fabre', '0641424344'],
            ['Sarah', 'Casabianca', '0651525354'],
            ['Juan', 'Rojas Cuicas', '0661626364'],
            ['Lucas', 'Merlet', '0671727374'],
            ['Nemo', 'Capitaine', '0681828384'],
            ['Nathanael', 'Kenzey', '0691929394'],
            ['Mélanie', 'Saez', '0602030405'],
            ['Anthony', 'Lutard', '0612131415'],
        ];

        foreach ($interns as [$firstName, $lastName, $phone]) {
            $intern = new Intern();
            $intern->setFirstName($firstName);
            $intern->setLastName($lastName);
            $intern->setPhone($phone);
            $manager->persist($intern);
        }

        // --- The single admin account ---
        $admin = new User();
        $admin->setLogin('ADMINAFPA');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'ECF@BEGLES')
        );
        $manager->persist($admin);

        // --- Save everything in one go ---
        $manager->flush();
    }
}