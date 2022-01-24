<?php
namespace App\Model;
use \DateTime;
use App\Helpers\text;

class Post {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name; 

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $content;

    /**
     * @var 
     */
    private $created_at;

    /**
     * @var array
     */
    private $categories = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getFormattedContent(): ?string
    {
        return nl2br(e($this->content));
    }

    public function getExcerpt(): ?string 
    {
        if($this->content === NULL){
            return null;
        }
        return nl2br(htmlentities(text::excerpt($this->content, 60)));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;
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

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Categorie[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(Categorie $categorie): void
    {
        $this->categories[]=$categorie;

    }



}