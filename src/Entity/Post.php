<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

// utilisation enum perso :

    const TYPE_VIDEO = 'Vidéo';
    const TYPE_POST = 'Post';
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $post_type;


    const STATUS_OPEN = 'open';
    const STATUS_CLOSE = 'close';
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;


// liaisons automatiques

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", inversedBy="post", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinTable(name="post_category")
     */
    private $categories;




    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }



    public function getPostType(): ?string
    {
        return $this->post_type;
    }
/*
    public function setPostType(string $post_type): self
    {
        $this->post_type = $post_type;

        return $this;
    }
*/
    public function setPostType($post_type)
    {
        if (!in_array($post_type, array(self::TYPE_VIDEO, self::TYPE_POST))) {
            throw new \InvalidArgumentException("Invalid post_type");
        }
        $this->post_type = $post_type;
    }
    
    
    public function getStatus(): ?string
    {
        return $this->status;
    }
/*
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
*/
    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_OPEN, self:: STATUS_CLOSE))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }


//methodes jointure onetoone manytomany :

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category=null): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
