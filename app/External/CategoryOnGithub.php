<?php


namespace App\External;


use Illuminate\Support\Stringable;

class CategoryOnGithub extends Stringable
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct($name);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}