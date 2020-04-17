<?php


namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


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
     * @ORM\Column(type="string", unique=true)
     */
    private $titlePost;

    /**
     * @Gedmo\Slug(fields={"titlePost"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $textPost;

    /**
     * @ORM\COLUMN(type="string", unique=true)
     */
    private $nameMainImagePost;

    /**
     * @var \DateTime
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $dateCreationPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */
    private $user;



    /*
     *  Getter and Setter
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitlePost(): ?string
    {
        return $this->titlePost;
    }

    public function setTitlePost(string $titlePost):  self
    {
        $this->titlePost = $titlePost;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTextPost(): ?string
    {
        return $this->textPost;
    }

    public function setTextPost(string $textPost): self
    {
        $this->textPost = $textPost;

        return $this;
    }

    public function getNameMainImagePost(): ?string
    {
        return $this->nameMainImagePost;
    }

    public function setNameMainImagePost(string $nameMainImagePost): self
    {
        $this->nameMainImagePost = $nameMainImagePost;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreationPost(): ?\DateTime
    {
        return $this->dateCreationPost;
    }

    /**
     * @param \DateTime $dateCreationPost
     * @return $this
     */
    public function setDateCreationPost(\DateTime $dateCreationPost): self
    {
        $this->dateCreationPost = $dateCreationPost;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
