<?php

namespace minipoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="idcateg", columns={"idcateg"})})
 * @ORM\Entity(repositoryClass="minipoBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idprod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprod;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=50, nullable=false)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtestock", type="integer", nullable=false)
     */
    private $qtestock;


    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcateg", referencedColumnName="idcateg")
     * })
     */
    private $idcateg;

    /**
     * @var \Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="Fournisseur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idf", referencedColumnName="idf")
     * })
     */
    private $idf;

    /**
     * @var string
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     * @Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/GIF"})
     */
    private $photo;

    /**
     * @return int
     */
    public function getIdprod()
    {
        return $this->idprod;
    }

    /**
     * @param int $idprod
     */
    public function setIdprod($idprod)
    {
        $this->idprod = $idprod;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return int
     */
    public function getQtestock()
    {
        return $this->qtestock;
    }

    /**
     * @param int $qtestock
     */
    public function setQtestock($qtestock)
    {
        $this->qtestock = $qtestock;
    }

    /**
     * @return \Categorie
     */
    public function getIdcateg()
    {
        return $this->idcateg;
    }

    /**
     * @param \Categorie $idcateg
     */
    public function setIdcateg($idcateg)
    {
        $this->idcateg = $idcateg;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @return \Fournisseur
     */
    public function getIdf()
    {
        return $this->idf;
    }

    /**
     * @param \Fournisseur $idf
     */
    public function setIdf($idf)
    {
        $this->idf = $idf;
    }





}

