<?php


namespace App\External;


use Illuminate\Support\Stringable;

class AuthorityOnGithub extends Stringable
{
    /**
     * @var CategoryOnGithub
     */
    private CategoryOnGithub $category;
    private string $authorityName;

    public function __construct(CategoryOnGithub $category, string $authorityName)
    {
        $this->category = $category;
        $this->authorityName = $authorityName;
        parent::__construct($category->getName() . ':' . $this->authorityName);
    }

    /**
     * @return CategoryOnGithub
     */
    public function getCategory(): CategoryOnGithub
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->authorityName;
    }
}