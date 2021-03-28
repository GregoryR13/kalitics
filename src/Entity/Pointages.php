<?php

namespace App\Entity;

use App\Repository\PointagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointagesRepository::class)
 */
class Pointages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chantiers")
     * @ORM\JoinColumn(name="chantier_id", referencedColumnName="id")
     */
    private $chantierId;

    /**
     * @ORM\Column(type="date")
     */
    private $datePointage;

    /**
     * @ORM\Column(type="time")
     */
    private $dureePointage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(Users $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getChantierId(): ?Chantiers
    {
        return $this->chantierId;
    }

    public function setChantierId(Chantiers $chantierId): self
    {
        $this->chantierId = $chantierId;

        return $this;
    }

    public function getDatePointage(): ?\DateTimeInterface
    {
        return $this->datePointage;
    }

    public function setDatePointage(\DateTimeInterface $datePointage): self
    {
        $this->datePointage = $datePointage;

        return $this;
    }

    public function getDureePointage(): ?\DateTimeInterface
    {
        return $this->dureePointage;
    }

    public function setDureePointage(\DateTimeInterface $dureePointage): self
    {
        $this->dureePointage = $dureePointage;

        return $this;
    }
}
