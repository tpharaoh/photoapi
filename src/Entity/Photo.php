<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\PhotoViewCountController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
*           "get",
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     "update_view_count"={
 *         "method"="GET",
 *         "path"="/photos/{id}/viewCounter",
 *         "controller"=PhotoViewCountController::class,
 *     }
 *     },
 *
 *      collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_ADMIN')"}
 *       }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("view")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("view")
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("view")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="photo")
     */
    private $tags;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewCount;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

//    public function setCreatedAt(\DateTimeInterface $createdAt): self
//    {
//        $this->createdAt = $createdAt;
//
//        return $this;
//    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
            $tag->addPhoto($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removePhoto($this);
        }

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }
}
