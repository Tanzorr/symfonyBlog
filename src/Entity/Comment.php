<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\Table (name="comments")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $upruwed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }



    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

//    public function setCreatedAt(): self
//    {
//        if(isset($this->created_at2))
//            $this->created_at = $this->created_at2;
//        else
//            $this->created_at = new \DateTime();
//        return $this;
//    }

//    public function setCreatedAtForFixtures($created_at): self
//    {
//        $this->created_at = $created_at;
//
//        return $this;
//    }

    public function getRelation(): ?User
    {
        return $this->relation;
    }

    public function setRelation(?User $relation): self
    {

       // dd($relation);
        $this->relation = $relation;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUpruwed(): ?bool
    {
        return $this->upruwed;
    }

    public function setUpruwed(?bool $upruwed): self
    {
        $this->upruwed = $upruwed;

        return $this;
    }
}
