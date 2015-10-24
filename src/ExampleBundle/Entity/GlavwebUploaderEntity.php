<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Glavweb\UploaderBundle\Mapping\Annotation as Glavweb;

/**
 * GlavwebUploaderEntity
 *
 * @Glavweb\Uploadable
 */
class GlavwebUploaderEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Glavweb\UploaderBundle\Entity\Media", inversedBy="GlavwebUploaderEntities", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Glavweb\UploadableField(mapping="entity_images", nameAddFunction="addImage", nameGetFunction="getImages")
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add images
     *
     * @param \Glavweb\UploaderBundle\Entity\Media $images
     * @return Product
     */
    public function addImage(\Glavweb\UploaderBundle\Entity\Media $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Glavweb\UploaderBundle\Entity\Media $images
     */
    public function removeImage(\Glavweb\UploaderBundle\Entity\Media $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
