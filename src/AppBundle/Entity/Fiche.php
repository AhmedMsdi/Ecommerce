<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 10/14/18
 * Time: 1:53 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fiche
 *
 * @ORM\Table(name="Fiche")
 * @ORM\Entity
 */
class Fiche
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
     * @ORM\Column(name="nameDetail", type="string", length=255, nullable=false)
     */
    private $nameDetail;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="fiches")
     * @ORM\JoinColumn(name="idProduct", referencedColumnName="id")
     */
    private $idproduct;



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
    public function getNameDetail()
    {
        return $this->nameDetail;
    }

    /**
     * @param string $nameDetail
     */
    public function setNameDetail($nameDetail)
    {
        $this->nameDetail = $nameDetail;
    }

    /**
     * @return Product
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }

    /**
     * @param Product $idproduct
     */
    public function setIdproduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }
    /**
     * Add a product in the category.
     *
     * @param $product Product The product to associate
     */
    public function addIdproduct($product)
    {
        if ($this->idproduct->contains($product)) {
            return;
        }

        $this->idproduct->add($product);
        $product->addFiche($this);
    }

    /**
     * @param Product $product
     */
    public function removeIdproduct($product)
    {
        if (!$this->idproduct->contains($product)) {
            return;
        }

        $this->idproduct->removeElement($product);
        $product->removeFiche($this);
    }


    /** {@inheritdoc} */
    public function __toString()
    {
        return '';
    }

}