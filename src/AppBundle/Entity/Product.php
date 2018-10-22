<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Categorie;
/**
 * Product
 *
 * @ORM\Table(name="Product", indexes={@ORM\Index(name="idCategorie", columns={"idCategorie"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Product
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
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAvailable", type="boolean", nullable=false)
     */
    private $isavailable;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=255, nullable=true)
     */
    private $reference;



    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="idCategorie", referencedColumnName="id")
     */
    private $idcategorie;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marque")
     * @ORM\JoinColumn(name="idMarque", referencedColumnName="id")
     */
    private $idmarque;

    /**
     * Features of the product.
     * Associative array, the key is the name/type of the feature, and the value the data.
     * Example:<pre>array(
     *     'size' => '13cm x 15cm x 6cm',
     *     'bluetooth' => '4.1'
     * )</pre>.
     *
     * @var array
     * @ORM\Column(type="array")
     */
    private $features =array('Caractere'=>array('Detail'=>'','Valeur'=>''));

    /**
     * @return array
     */
    public function getFeatures()
    {
        return [];
    }

    /**
     * @param array $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }




    /**
     * @var Fiche[]
     *@ORM\OneToMany(targetEntity="Fiche", mappedBy="Product", cascade={"remove"})
     */
    private $fiches;

    public function __construct()
    {
        $this->fiches = new ArrayCollection();
    }

    /**
     * Add a category in the product association.
     * (Owning side).
     *
     * @param fiche Fiche the category to associate
     */
    public function addFiche($fiche)
    {
        if ($this->fiches->contains($fiche)) {
            return;
        }

        $this->fiches->add($fiche);
        $fiche->addProduct($this);
    }

    /**
     * Remove a category in the product association.
     * (Owning side).
     *
     * @param $fiche Fiche the category to associate
     */
    public function removeFiche($fiche)
    {
        if (!$this->fiches->contains($fiche)) {
            return;
        }

        $this->fiches->removeElement($fiche);
        $fiche->removeProduct($this);
    }


    /**
     * @return Fiche[]
     */
    public function getFiches()
    {
        return $this->fiches;
    }

    /**
     * @param Fiche[] $fiches
     */
    public function setFiches($fiches)
    {
        $this->fiches = $fiches;
    }





    /**
     * @return mixed
     */
    public function getIdmarque()
    {
        return $this->idmarque;
    }

    /**
     * @param mixed $idmarque
     */
    public function setIdmarque($idmarque)
    {
        $this->idmarque = $idmarque;
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
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function isIsavailable()
    {
        return $this->isavailable;
    }

    /**
     * @param bool $isavailable
     */
    public function setIsavailable($isavailable)
    {
        $this->isavailable = $isavailable;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }



    /**
     * @return \Categorie
     */
    public function getIdcategorie()
    {
        return $this->idcategorie;
    }

    /**
     * @param \Categorie $idcategorie
     */
    public function setIdcategorie($idcategorie)
    {
        $this->idcategorie = $idcategorie;
    }

    /**
     * Add a category in the product association.
     * (Owning side).
     *
     * @param $category Category the category to associate
     */
    public function addCategory($category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->idcategorie->add($category);
        $category->addProduct($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }


}

