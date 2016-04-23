<?php

namespace Defi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="Defi\CommonBundle\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(name="name_mg", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Part", cascade={"persist"})
     */
    private $part;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="string", length=255)
     */
    private $nameFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $nameEn;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

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
     * Set name
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Book
     */
    public function setNameFr($nameFr)
    {
        $this->nameFr = $nameFr;

        return $this;
    }

    /**
     * Get nameFr
     *
     * @return string
     */
    public function getNameFr()
    {
        return $this->nameFr;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Book
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    function getRank()
    {
        return $this->rank;
    }

    function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Set part
     *
     * @param \Defi\CommonBundle\Entity\Part $part
     *
     * @return Book
     */
    public function setPart(\Defi\CommonBundle\Entity\Part $part = null)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get part
     *
     * @return \Defi\CommonBundle\Entity\Part
     */
    public function getPart()
    {
        return $this->part;
    }

}
