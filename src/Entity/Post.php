<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Eko\FeedBundle\Item\Writer\RoutedItemInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post extends Content implements RoutedItemInterface
{

    /**
     * The post categories.
     *
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(
     *     name="post_category",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * The post tags.
     *
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(
     *     name="post_tag",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    /**
     * The post comments.
     *
     * @var Collection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

    /**
     * Post constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Return the post categories.
     *
     * @return Collection The post categories.
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Return the post tags.
     *
     * @return Collection The post tags.
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Return the post comments.
     *
     * @return Collection The post comments.
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * This method returns feed item title.
     *
     * @return string The feed item title.
     */
    public function getFeedItemTitle(): string
    {
        return $this->getTitle();
    }

    /**
     * This method returns feed item description (or content).

     * @return string The feed item description (or content).
     */
    public function getFeedItemDescription(): string
    {
        return $this->getContent();
    }

    /**
     * This method returns the name of the route.
     *
     * @return string
     */
    public function getFeedItemRouteName(): string
    {
        return 'post';
    }

    /**
     * This method returns the parameters for the route.
     *
     * @return array The parameters for the route.
     */
    public function getFeedItemRouteParameters(): array
    {
        return ['post' => $this->getSlug() === null ? $this->getId() : $this->getSlug()];
    }

    /**
     * This method returns the anchor to be appended on this item's url.
     *
     *
     * @return string The anchor, without the "#"
     */
    public function getFeedItemUrlAnchor(): string
    {
        return '';
    }

    /**
     * This method returns item publication date.

     * @return \DateTime The item publication date.
     */
    public function getFeedItemPubDate()
    {
        return $this->getPublishedAt();
    }
}