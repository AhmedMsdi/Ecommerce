<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 10/6/18
 * Time: 8:30 PM
 */

namespace AppBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
/**
 * Marque
 *
 * @ORM\Table(name="Marque")
 * @ORM\Entity
 * @Vich\Uploadable
 */

class Marque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $imageMarque;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageMarque")
     * @var File
     */
    private $imageFileMarque;
    public function setImageFileMarque(File $image = null)
    {
        $this->imageFileMarque = $image;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
    public function getImageFileMarque()
    {
        return $this->imageFileMarque;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getImageMarque()
    {
        return $this->imageMarque;
    }

    /**
     * @param string $imageMarque
     */
    public function setImageMarque($imageMarque)
    {
        $this->imageMarque = $imageMarque;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }





}