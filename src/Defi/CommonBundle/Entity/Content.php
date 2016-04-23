<?php

namespace Defi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="Defi\CommonBundle\Repository\ContentRepository")
 */
class Content
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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Book", cascade={"persist"})
     */
    private $book;

    /**
     * @var int
     *
     * @ORM\Column(name="chapter", type="integer")
     */
    private $chapter;

    /**
     * @var int
     *
     * @ORM\Column(name="verse", type="integer")
     */
    private $verse;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Translation", cascade={"persist"})
     */
    private $translation;


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
     * Set chapter
     *
     * @param integer $chapter
     *
     * @return Content
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * Get chapter
     *
     * @return int
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Set verse
     *
     * @param integer $verse
     *
     * @return Content
     */
    public function setVerse($verse)
    {
        $this->verse = $verse;

        return $this;
    }

    /**
     * Get verse
     *
     * @return int
     */
    public function getVerse()
    {
        return $this->verse;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Content
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set book
     *
     * @param \Defi\CommonBundle\Entity\Book $book
     *
     * @return Content
     */
    public function setBook(\Defi\CommonBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \Defi\CommonBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set translation
     *
     * @param \Defi\CommonBundle\Entity\Translation $translation
     *
     * @return Content
     */
    public function setTranslation(\Defi\CommonBundle\Entity\Translation $translation = null)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return \Defi\CommonBundle\Entity\Translation
     */
    public function getTranslation()
    {
        return $this->translation;
    }
}
