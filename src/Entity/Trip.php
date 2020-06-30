<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=TrackPoint::class, mappedBy="trip", orphanRemoval=true)
     */
    private $trackPoints;

    public function __construct()
    {
        $this->trackPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TrackPoint[]
     */
    public function getTrackPoints(): Collection
    {
        return $this->trackPoints;
    }

    public function addTrackPoint(TrackPoint $trackPoint): self
    {
        if (!$this->trackPoints->contains($trackPoint)) {
            $this->trackPoints[] = $trackPoint;
            $trackPoint->setTrip($this);
        }

        return $this;
    }

    public function removeTrackPoint(TrackPoint $trackPoint): self
    {
        if ($this->trackPoints->contains($trackPoint)) {
            $this->trackPoints->removeElement($trackPoint);
            // set the owning side to null (unless already changed)
            if ($trackPoint->getTrip() === $this) {
                $trackPoint->setTrip(null);
            }
        }

        return $this;
    }
}
