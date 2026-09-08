<?php

namespace App\Entity;

use App\Repository\InternRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InternRepository::class)]
class Intern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoPath = null;

    /**
     * @var Collection<int, Absence>
     */
    #[ORM\OneToMany(targetEntity: Absence::class, mappedBy: 'intern')]
    private Collection $absences;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $afpaNumber = null;

        #[ORM\Column(options: ['default' => false])]
    private bool $archived = false;

    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photoPath;
    }

    public function setPhotoPath(?string $photoPath): static
    {
        $this->photoPath = $photoPath;

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): static
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setIntern($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): static
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getIntern() === $this) {
                $absence->setIntern(null);
            }
        }

        return $this;
    }

    public function getAfpaNumber(): ?string
    {
        return $this->afpaNumber;
    }

    public function setAfpaNumber(string $afpaNumber): static
    {
        $this->afpaNumber = $afpaNumber;

        return $this;
    }
    public function countUnexcusedAbsences(): int
    {
        $count = 0;

        foreach ($this->absences as $absence) {
            if ($absence->getReason() !== null
                && $absence->getReason()->getLabel() === 'Sans motif') {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Is this intern flagged (more than 5 unexcused absences)?
     */
    public function isFlagged(): bool
    {
        return $this->countUnexcusedAbsences() > 5;
    }
    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }
}
