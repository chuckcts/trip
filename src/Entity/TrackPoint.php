<?php

namespace App\Entity;

use App\Repository\TrackPointRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrackPointRepository::class)
 */
class TrackPoint
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=17, scale=15)
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=15)
     */
    private $lon;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=16,nullable=true)
     */
    private $ele;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Trip::class, inversedBy="trackPoints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getEle(): ?string
    {
        return $this->ele;
    }

    public function setEle(string $ele): self
    {
        $this->ele = $ele;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }
}
