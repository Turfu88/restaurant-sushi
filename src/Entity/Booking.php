<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $people_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_no_show = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_honored = null;

    #[ORM\Column]
    private ?bool $is_canceled = null;

    #[ORM\Column(nullable: true)]
    private ?int $waiting_list = null;

    #[ORM\Column(nullable: true)]
    private ?int $table_number = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Establishment $establishment = null;

    /**
     * @var Collection<int, Customer>
     */
    #[ORM\ManyToMany(targetEntity: Customer::class, mappedBy: 'bookings')]
    private Collection $customers;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    private ?MealTime $mealTime = null;

    public function __construct()
    {
        $this->meal_time = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPeopleNumber(): ?int
    {
        return $this->people_number;
    }

    public function setPeopleNumber(int $people_number): static
    {
        $this->people_number = $people_number;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function isNoShow(): ?bool
    {
        return $this->is_no_show;
    }

    public function setNoShow(?bool $is_no_show): static
    {
        $this->is_no_show = $is_no_show;

        return $this;
    }

    public function isHonored(): ?bool
    {
        return $this->is_honored;
    }

    public function setHonored(?bool $is_honored): static
    {
        $this->is_honored = $is_honored;

        return $this;
    }

    public function isCanceled(): ?bool
    {
        return $this->is_canceled;
    }

    public function setCanceled(bool $is_canceled): static
    {
        $this->is_canceled = $is_canceled;

        return $this;
    }

    public function getWaitingList(): ?int
    {
        return $this->waiting_list;
    }

    public function setWaitingList(?int $waiting_list): static
    {
        $this->waiting_list = $waiting_list;

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->table_number;
    }

    public function setTableNumber(?int $table_number): static
    {
        $this->table_number = $table_number;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): static
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->addBooking($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeBooking($this);
        }

        return $this;
    }

    public function getMealTime(): ?MealTime
    {
        return $this->mealTime;
    }

    public function setMealTime(?MealTime $mealTime): static
    {
        $this->mealTime = $mealTime;

        return $this;
    }
}
