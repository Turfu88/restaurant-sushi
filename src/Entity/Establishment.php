<?php

namespace App\Entity;

use App\Repository\EstablishmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
class Establishment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $time_limit_before_cancel = null;

    #[ORM\Column]
    private ?int $available_seats = null;

    #[ORM\Column]
    private ?bool $is_open = null;

    #[ORM\Column]
    private ?int $opening_advanced_booking_days = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Menu>
     */
    #[ORM\OneToMany(targetEntity: Menu::class, mappedBy: 'establishment')]
    private Collection $menus;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'establishment')]
    private Collection $bookings;

    /**
     * @var Collection<int, StaffMember>
     */
    #[ORM\ManyToMany(targetEntity: StaffMember::class, inversedBy: 'establishments')]
    private Collection $staff_members;

    /**
     * @var Collection<int, MealTime>
     */
    #[ORM\OneToMany(targetEntity: MealTime::class, mappedBy: 'establishment')]
    private Collection $mealTimes;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->staff_members = new ArrayCollection();
        $this->mealTimes = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getTimeLimitBeforeCancel(): ?int
    {
        return $this->time_limit_before_cancel;
    }

    public function setTimeLimitBeforeCancel(int $time_limit_before_cancel): static
    {
        $this->time_limit_before_cancel = $time_limit_before_cancel;

        return $this;
    }

    public function getAvailableSeats(): ?int
    {
        return $this->available_seats;
    }

    public function setAvailableSeats(int $available_seats): static
    {
        $this->available_seats = $available_seats;

        return $this;
    }

    public function isOpen(): ?bool
    {
        return $this->is_open;
    }

    public function setOpen(bool $is_open): static
    {
        $this->is_open = $is_open;

        return $this;
    }

    public function getOpeningAdvancedBookingDays(): ?int
    {
        return $this->opening_advanced_booking_days;
    }

    public function setOpeningAdvancedBookingDays(int $opening_advanced_booking_days): static
    {
        $this->opening_advanced_booking_days = $opening_advanced_booking_days;

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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setEstablishment($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getEstablishment() === $this) {
                $menu->setEstablishment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setEstablishment($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getEstablishment() === $this) {
                $booking->setEstablishment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StaffMember>
     */
    public function getStaffMembers(): Collection
    {
        return $this->staff_members;
    }

    public function addStaffMember(StaffMember $staffMember): static
    {
        if (!$this->staff_members->contains($staffMember)) {
            $this->staff_members->add($staffMember);
        }

        return $this;
    }

    public function removeStaffMember(StaffMember $staffMember): static
    {
        $this->staff_members->removeElement($staffMember);

        return $this;
    }

    /**
     * @return array<int, MealTime>
     */
    public function getMealTimes(): array
    {
        return $this->mealTimes->getValues();
    }

    public function addMealTime(MealTime $mealTime): static
    {
        if (!$this->mealTimes->contains($mealTime)) {
            $this->mealTimes->add($mealTime);
            $mealTime->setEstablishment($this);
        }

        return $this;
    }

    public function removeMealTime(MealTime $mealTime): static
    {
        if ($this->mealTimes->removeElement($mealTime)) {
            // set the owning side to null (unless already changed)
            if ($mealTime->getEstablishment() === $this) {
                $mealTime->setEstablishment(null);
            }
        }

        return $this;
    }
}
