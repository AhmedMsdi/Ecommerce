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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
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
     * @return mixed
     */
    public function getIdproduct()
    {
        return $this->idproduct;
    }

    /**
     * @param mixed $idproduct
     */
    public function setIdproduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }


}