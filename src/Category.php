<?php
namespace woojos\kontomierz;

/**
 * Class Category
 * @package woojos\Kontomierz
 */
class Category
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
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

}