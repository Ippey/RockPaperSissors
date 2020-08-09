<?php

namespace App\Entity;

use App\Repository\CPULogsRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=CPULogsRepository::class)
 */
class CPULogs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $hand;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct(int $hand,DateTime $date)
    {
        $this->hand = $hand;
        $this->date = $date;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHand(): ?int
    {
        return $this->hand;
    }

    public function setHand(int $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
