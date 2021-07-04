<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Schema\Constraint as Assert;


/**
 * @ORM\Entity(repositoryClass=AdRepository::class)
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ads")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, mappedBy="ads")
     */
    private $contacts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $assets;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $show_amount;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="ads")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surface = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rooms = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bathroom = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $handicap_accessibility;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sell;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sold;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $renting;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $publication_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $update_at;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts): void
    {
        $this->contacts = $contacts;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

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
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->addAd($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            $contact->removeAd($this);
        }

        return $this;
    }

    public function getAssets(): ?string
    {
        return $this->assets;
    }

    public function setAssets(?string $assets): self
    {
        $this->assets = $assets;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShowAmount(): ?bool
    {
        return $this->show_amount;
    }

    public function setShowAmount(?bool $show_amount): self
    {
        $this->show_amount = $show_amount;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }



    public function toArray() {
        return [
            'id' => $this->getId(),
            'comment' => $this->getComment(),
            'assets' => $this->getAssets(),
            'description' => $this->getDescription(),
            'street' => $this->getStreet(),
            'title' => $this->getTitle(),
            'city' => $this->getCity(),
            'show_amount' => $this->getShowAmount(),
            'country' => $this->getCountry(),
            'published' => $this->getPublished(),
            'amount' => $this->getAmount(),
            'tags' => $this->getTags(),
        ];
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(?string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBathroom(): ?int
    {
        return $this->bathroom;
    }

    public function setBathroom(?int $bathroom): self
    {
        $this->bathroom = $bathroom;

        return $this;
    }

    public function getHandicapAccessibility(): ?bool
    {
        return $this->handicap_accessibility;
    }

    public function setHandicapAccessibility(?bool $handicap_accessibility): self
    {
        $this->handicap_accessibility = $handicap_accessibility;

        return $this;
    }

    public function getSell(): ?bool
    {
        return $this->sell;
    }

    public function setSell(?bool $sell): self
    {
        $this->sell = $sell;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(?bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getRenting(): ?bool
    {
        return $this->renting;
    }

    public function setRenting(?bool $renting): self
    {
        $this->renting = $renting;

        return $this;
    }


    public function arrayToAdObject($data) {
        if ($data['id'] != 0 && $data['id'] == null) {
            $this->setId($data['id']);
        }
        $this->setAmount($data['amount']);
        $this->setTitle($data['title']);
        $this->setDescription($data['description']);
        $this->setBathroom($data['bathrooom'] ?? 0 );
        $this->setHandicapAccessibility($data['handicap_accessibility']);
        $this->setShowAmount($data['show_amount']);
        $this->setZipcode($data['zipcode']);
        $this->setStreet($data['street']);
        $this->setAssets($data['assets']);
        $this->setPublished($data['published']);
        $this->setComment($data['comment']);
        $this->setSold($data['sold']);
        $this->setRooms($data['rooms']);
        $this->setTags($data['tags']);
    }

    public function updateAd(Ad $ad, $data) {
        $ad->setAmount((int) $data['amount']);
        $ad->setTitle($data['title']);
        $ad->setDescription($data['description']);
        $ad->setBathroom($data['bathrooom'] ?? 0 );
        $ad->setHandicapAccessibility($data['handicap_accessibility']);
        $ad->setShowAmount($data['show_amount']);
        $ad->setZipcode($data['zipcode']);
        $ad->setStreet($data['street']);
        $ad->setAssets($data['assets']);
        $ad->setPublished($data['published']);
        $ad->setComment($data['comment']);
        $ad->setSold($data['sold']);
        $ad->setRooms($data['rooms']);
        $ad->setTags($data['tags']);
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?\DateTimeInterface $publication_date): self
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }
}
