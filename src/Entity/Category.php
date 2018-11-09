<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Content category
 *
 * @ORM\Entity()
 */
class Category
{
    /**
     * The category identifier.
     *
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The category name.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * The category slug.
     *
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * The category description.
     *
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * The parent category.
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * Return the category identifier.
     *
     * @return int The category identifier.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return the category name.
     *
     * @return string The category name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the category name.
     *
     * @param string $name The category name.
     * @return Category The category.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * The category slug.
     *
     * @return string The category slug.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the category slug.
     *
     * @param string $slug The category slug.
     * @return Category The category.
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Return category description.
     *
     * @return string The category description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the category description.
     *
     * @param string $description The category description.
     * @return Category The category.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the parent category.
     *
     * @return Category The parent category.
     */
    public function getParent(): self
    {
        return $this->parent;
    }

    /**
     * Set the parent category.
     *
     * @param Category $parent The parent category.
     * @return Category The category.
     */
    public function setParent(Category $parent): Category
    {
        $this->parent = $parent;

        return $this;
    }

}