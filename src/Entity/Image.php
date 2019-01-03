<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(name="`dimension`", type="string", nullable=true)
     */
    private $dimension;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Post", mappedBy="image", cascade={"persist", "remove"})
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDimension()
    {
        return $this->dimension;
    }

    public function setDimension($dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $post === null ? null : $this;
        if ($newImage !== $post->getImage()) {
            $post->setImage($newImage);
        }

        return $this;
    }
}
