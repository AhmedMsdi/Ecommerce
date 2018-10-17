<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 10/14/18
 * Time: 4:38 PM
 */

namespace AppBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
/**
 * Publicite
 *
 * @ORM\Table(name="Publicite")
 * @ORM\Entity
 * @Vich\Uploadable
 */

class Publicite
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
     * @ORM\Column(name="position", type="string", length=255, nullable=false)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $imagePub;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imagePub")
     * @var File
     */
    private $imageFilePub;
    public function setImageFilePub(File $image = null)
    {
        $this->imageFilePub = $image;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFilePub()
    {
        return $this->imageFilePub;
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
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getImagePub()
    {
        return $this->imagePub;
    }

    /**
     * @param string $imagePub
     */
    public function setImagePub($imagePub)
    {
        $this->imagePub = $imagePub;
    }



}