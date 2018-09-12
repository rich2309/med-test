<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DSD
 *
 * @ORM\Table(name="dsd")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DSDRepository")
 */
class DSD
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="manufacturer", type="string", length=255, nullable=true)
     */
    private $manufacturer;

    /**
     * @var int
     *
     * @ORM\Column(name="item_sds", type="integer", nullable=true)
     */
    private $itemSds;


    /**
     * @Vich\UploadableField(mapping="dsd_file", fileNameProperty="fileName", size="fileSize")
     *
     * @var \Symfony\Component\HttpFoundation\File\File|null
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $fileSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @Assert\Callback(
     *     message="Wrong file type. Please only .pdf !"
     *     )
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if(!is_null($this->file))
        {
            if (!in_array($this->file->getMimeType(), ['application/pdf']))
            {
                $context
                    ->buildViolation('Wrong file type. Please only .pdf !')
                    ->atPath('fileName')
                    ->addViolation()
                ;
            }
        }

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return DSD
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return DSD
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set itemSds
     *
     * @param integer $itemSds
     *
     * @return DSD
     */
    public function setItemSds($itemSds)
    {
        $this->itemSds = $itemSds;

        return $this;
    }

    /**
     * Get itemSds
     *
     * @return int
     */
    public function getItemSds()
    {
        return $this->itemSds;
    }
}

