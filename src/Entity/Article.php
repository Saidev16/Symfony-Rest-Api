<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;



/**
 * @ApiResource(
 *  normalizationContext={"groups"={"article:read"}},
 *  denormalizationContext={"groups"={"article:write"}}
 * )
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"article:read"})
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=255)
     * 
     * @Groups({"article:read", "article:write"})
     */
    private $title;


    /**
     * @ORM\Column(type="string",length=255)
     * 
     * @Groups({"article:read"})
     */
    private $slug;


    /**
     * @ORM\Column(type="text",length=255, nullable=true)
     * 
     * @Groups({"article:read", "article:write"})
     */
    private $content;


    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     * 
     * @Groups({"article:read", "article:write"})
     */
    private $picture;


    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"article:read"})
     */
    private $isPublished;


    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"article:read"})
     */
    private $publishedAt;


    /**
     * @ORM\Column(type="datetime",nullable=true)
     * 
     *  @Groups({"article:read"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article")
     * @ApiSubresource
     * 
     * @Groups("article:read")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles",cascade={"persist"})
     * 
     * @Groups({"article:read", "article:write"})
     */
    private $tags;


    public function __construct()
    {
        $this->isPublished = false;
        $this->publishedAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle()
    {
    return $this->title;
    }

    public function setTitle($title)
    {
    $this->title = $title;

    return $this;
    }

    
    public function getSlug()
    {
    return $this->slug;
    }

    public function setSlug($slug)
    {
    $this->slug = $slug;

    return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }






}
