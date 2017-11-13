<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntryTag
 *
 * @ORM\Table(name="entry_tag", indexes={@ORM\Index(name="IDX_F035C9E5BA364942", columns={"entry_id"}), @ORM\Index(name="IDX_F035C9E5BAD26311", columns={"tag_id"})})
 * @ORM\Entity
 */
class EntryTag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="entry_tag_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Entry
     *
     * @ORM\ManyToOne(targetEntity="Entry", inversedBy="entryTag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entry_id", referencedColumnName="id")
     * })
     */
    private $entry;

    /**
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag"), inversedBy="entryTag"
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;



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
     * Set entry
     *
     * @param \BlogBundle\Entity\Entry $entry
     *
     * @return EntryTag
     */
    public function setEntry(\BlogBundle\Entity\Entry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \BlogBundle\Entity\Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set tag
     *
     * @param \BlogBundle\Entity\Tag $tag
     *
     * @return EntryTag
     */
    public function setTag(\BlogBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \BlogBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
