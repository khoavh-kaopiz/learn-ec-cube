<?php

declare(strict_types=1);

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\AbstractEntity;

/**
 * @ORM\Table(name="dtb_sale")
 * @ORM\Entity(repositoryClass="Customize\Repository\SaleRepository")
 */
class Sale extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $discount_type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $discount_amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $from_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $to_date;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $visible;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDiscountType(): ?int
    {
        return $this->discount_type;
    }

    /**
     * @param int $discount_type
     * @return self
     */
    public function setDiscountType(int $discount_type): self
    {
        $this->discount_type = $discount_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscountAmount(): ?string
    {
        return $this->discount_amount;
    }

    /**
     * @param string $discount_amount
     * @return self
     */
    public function setDiscountAmount(string $discount_amount): self
    {
        $this->discount_amount = $discount_amount;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->from_date;
    }

    /**
     * @param \DateTimeInterface $from_date
     * @return self
     */
    public function setFromDate(\DateTimeInterface $from_date): self
    {
        $this->from_date = $from_date;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getToDate(): ?\DateTimeInterface
    {
        return $this->to_date;
    }

    /**
     * @param \DateTimeInterface $to_date
     * @return self
     */
    public function setToDate(\DateTimeInterface $to_date): self
    {
        $this->to_date = $to_date;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return self
     */
    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }
}
