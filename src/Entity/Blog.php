<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
*           "get",
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     "put"={"security"="is_granted('ROLE_ADMIN')"},
*   }
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *     "tags": "exact",
 *     "owner.name": "partial"
 *     })
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 */
class Blog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("view")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("view")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("view")
     */
    private $mainbody;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="blogs")
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("view")
     */
    private $createdAt;

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

    public function getMainbody(): ?string
    {
        return $this->mainbody;
    }

    public function setMainbody(string $mainbody): self
    {
        $this->mainbody = $mainbody;

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
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

//    public function setCreatedAt(?\DateTimeInterface $createdAt): self
//    {
//        $this->createdAt = $createdAt;
//        return $this;
//    }
}
