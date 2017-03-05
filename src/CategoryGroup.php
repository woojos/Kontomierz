<?php
namespace woojos\Kontomierz;

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
}