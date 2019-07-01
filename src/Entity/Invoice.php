<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @ORM\Table(name="invoices",
 *  uniqueConstraints={
 * @ORM\UniqueConstraint(name="number_idx", columns={"number"})
 * })
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity("number")
 */
class Invoice {

    const PAYMENT_METHOD_TRANSFER = 'transfer';
    const PAYMENT_METHOD_CASH = 'cash';
    const PAYMENT_METHOD_CARD = 'card';
    
    public static $paymentMethods = [
        'Przelew' => self::PAYMENT_METHOD_TRANSFER,
        'Gotówka' => self::PAYMENT_METHOD_CASH,
        'Karta' => self::PAYMENT_METHOD_CARD
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @var string
     * @ORM\Column(name="number", type="string", length=64, nullable=false)
     */
    private $number;

    /**
     * @Assert\NotBlank
     * @var \DateTime
     * @ORM\Column(name="issue_date", type="date", nullable=false)
     */
    private $issueDate;

    /**
     * @Assert\NotBlank
     * @var \DateTime
     * @ORM\Column(name="sale_date", type="date", nullable=false)
     */
    private $saleDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="payment_date", type="date", nullable=true)
     */
    private $paymentDate;

    /**
     * @Assert\NotBlank
     * @var string
     * @ORM\Column(name="payment_method", type="string", length=16, nullable=false)
     */
    private $paymentMethod;    

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "Faktura musi posiadać przynajmniej jedną pozycję"
     * )
     * @ORM\OneToMany(targetEntity="Item", mappedBy="invoice", cascade={"all"}, orphanRemoval=true)
     */
    private $items; 
    
    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumn(name="buyer_id", referencedColumnName="id", nullable=false)
     */
    private $buyer;
    
    /**
     * @ORM\ManyToOne(targetEntity="BankAccount")
     * @ORM\JoinColumn(name="bank_account_id", referencedColumnName="id", nullable=true)
     */
    private $bankAccount;    

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(\DateTimeInterface $issueDate): self
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->saleDate;
    }

    public function setSaleDate(\DateTimeInterface $saleDate): self
    {
        $this->saleDate = $saleDate;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setInvoice($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getInvoice() === $this) {
                $item->setInvoice(null);
            }
        }

        return $this;
    }

    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }

    public function setBuyer(?Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }    

}
