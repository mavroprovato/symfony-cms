<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Content Tag
 *
 * @ORM\Entity()
 */
class Tag
{
    /**
     * The tag identifier.
     *
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The tag name.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * The tag slug.
     *
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * The tag description.
     *
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * Return the tag identifier.
     *
     * @return int The tag identifier.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return the tag name.
     *
     * @return string The tag name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the tag name.
     *
     * @param string $name The tag name.
     * @return Tag The tag.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return the tag slug.
     *
     * @return string The tag slug.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the tag slug.
     *
     * @param string $slug The tag slug.
     * @return Tag The tag.
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Return the tag description.
     *
     * @return string The tag description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the tag description.
     *
     * @param string $description The tag description.
     * @return Tag The tag.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}