<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"post" = "Post", "page" = "Page"})
 */
abstract class Content
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="status", type="ContentStatusType", nullable=false)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\ContentStatusType")
     */
    private $status;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * Get the content identifier.
     *
     * @return int The content identifier.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the content title.
     *
     * @return string The content title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the content title.
     *
     * @param string $title The content title.
     * @return Content The content.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the content.
     *
     * @return string The content.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the content.
     *
     * @param string $content The content.
     * @return Content The content.
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the status.
     *
     * @return string The content.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the status.
     *
     * @param string $status The status.
     * @return Content The content.
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the slug.
     *
     * @return string The slug.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the slug.
     *
     * @param string $slug The slug.
     * @return Content The content.
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the creation date of the content.
     *
     * @return \DateTime The creation date of the content.
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Get the update date of the content.
     *
     * @return \DateTime The update date of the content.
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Get the publication date of the content.
     *
     * @return \DateTime The publication date of the content.
     */
    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    /**
     * Set the publication date of the content.
     *
     * @param \DateTime $publishedAt The publication date of the content.
     * @return Content The content.
     */
    public function setPublishedAt(\DateTime $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
