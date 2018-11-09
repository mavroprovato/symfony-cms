<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page extends Content
{
    /**
     * @var integer
     * @ORM\Column(name="page_order", type="integer")
     */
    private $order;

    /**
     * Get the page order.
     *
     * @return int|null The page order.
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }

    /**
     * Set the page order.
     *
     * @param int $order The page order.
     * @return Page The page.
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }
}