<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eko\FeedBundle\Item\Writer\RoutedItemInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Comment on a post
 *
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment implements RoutedItemInterface
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
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="web_site", type="string", nullable=true)
     */
    private $webSite;

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
     * The post.
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Comment
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Comment
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Comment
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    /**
     * @param string $webSite
     * @return Comment
     */
    public function setWebSite(string $webSite): self
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Comment
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return Comment
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * This method returns feed item title.
     *
     * @return string
     */
    public function getFeedItemTitle()
    {
        return 'Comment';
    }

    /**
     * This method returns feed item description (or content).
     *
     * @return string
     */
    public function getFeedItemDescription()
    {
        return $this->comment;
    }

    /**
     * This method returns the name of the route.
     *
     * @return string
     */
    public function getFeedItemRouteName()
    {
        return 'post';
    }

    /**
     * This method returns the parameters for the route.
     *
     * @return array
     */
    public function getFeedItemRouteParameters()
    {
        return [
            'post' => $this->getPost()->getSlug() === null ? $this->getPost()->getId() : $this->getPost()->getSlug()
        ];
    }

    /**
     * This method returns the anchor to be appended on this item's url.
     *
     * @return string The anchor, without the "#"
     */
    public function getFeedItemUrlAnchor()
    {
        return 'comment-' . $this->id;
    }

    /**
     * This method returns item publication date.
     *
     * @return \DateTime
     */
    public function getFeedItemPubDate()
    {
        return $this->createdAt;
    }
}