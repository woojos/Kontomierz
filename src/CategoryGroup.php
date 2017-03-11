<?php
namespace woojos\kontomierz;

/**
 * Class CategoryGroup
 * @package woojos\Kontomierz
 */
class CategoryGroup
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var Category[] */
    private $categories;

    /**
     * @param int $id
     * @param string $name
     * @param Category[] $categories
     */
    public function __construct($id, $name, array $categories)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categories = $categories;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
}