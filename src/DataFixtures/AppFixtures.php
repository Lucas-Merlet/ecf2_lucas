<?php

namespace App\DataFixtures;

use App\Entity\Absence;
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
        $reasons = [];

        foreach ($reasonLabels as $label) {
            $reason = new Reason();
            $reason->setLabel($label);
            $manager->persist($reason);
            $reasons[$label] = $reason; // keep a reference by label
        }

        // --- The 12 trainees ---
        $internsData = [
            ['22116576', 'Adila', 'Kehlaoui', '0601020304'],
            ['26020093', 'Mohammed', 'Benerroua', '0611121314'],
            ['26020095', 'Ghislène', 'Bellia', '0621222324'],
            ['26020096', 'Aurèle', 'Camps', '0631323334'],
            ['26020097', 'Nelly', 'Fabre', '0641424344'],
            ['26020141', 'Sarah', 'Casabianca', '0651525354'],
            ['26020143', 'Juan', 'Rojas Cuicas', '0661626364'],
            ['26020156', 'Lucas', 'Merlet', '0671727374'],
            ['26020263', 'Nemo', 'Capitaine', '0681828384'],
            ['26020268', 'Nathanael', 'Kenzey', '0691929394'],
            ['26020916', 'Anthony', 'Lutard', '0602030405'],
            ['26028145', 'Mélanie', 'Saez', '0612131415'],
        ];

        $interns = [];
        foreach ($internsData as [$afpaNumber, $firstName, $lastName, $phone]) {
            $intern = new Intern();
            $intern->setAfpaNumber($afpaNumber);
            $intern->setFirstName($firstName);
            $intern->setLastName($lastName);
            $intern->setPhone($phone);
            $manager->persist($intern);
            $interns[] = $intern; // keep references
        }

        // --- Sample absences (date, intern index, reason label) ---
        $absencesData = [
            // Intern 0 (Adila) : 6 "Sans motif" -> should appear in red later
            ['2026-09-01', 0, 'Sans motif'],
            ['2026-09-02', 0, 'Sans motif'],
            ['2026-09-03', 0, 'Sans motif'],
            ['2026-09-08', 0, 'Sans motif'],
            ['2026-09-09', 0, 'Sans motif'],
            ['2026-09-10', 0, 'Sans motif'],
            // Others
            ['2026-09-04', 1, 'Maladie'],
            ['2026-09-05', 2, 'Absence légale'],
            ['2026-09-11', 3, 'Accident du travail'],
            ['2026-09-12', 1, 'Sans motif'],
            ['2026-09-15', 4, 'Maladie'],
            ['2026-09-16', 4, 'Maladie'],
        ];

        foreach ($absencesData as [$date, $internIndex, $reasonLabel]) {
            $absence = new Absence();
            $absence->setDate(new \DateTime($date));
            $absence->setIntern($interns[$internIndex]);
            $absence->setReason($reasons[$reasonLabel]);
            $manager->persist($absence);
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
