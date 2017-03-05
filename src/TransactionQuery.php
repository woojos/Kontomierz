<?php
namespace woojos\Kontomierz;

/**
 * Class TransactionQuery
 * @package woojos\Kontomierz
 */
class TransactionQuery
{
    /** @var int */
    private $page;
    /** @var int */
    private $perPage;
    /** @var int */
    private $userAccountId;
    /** @var string */
    private $query;
    /** @var \DateTimeInterface */
    private $startOn;
    /** @var \DateTimeInterface */
    private $endOn;
    /** @var string */
    private $direction;
    /** @var string */
    private $tagName;
    /** @var int */
    private $categoryGroupId;
    /** @var int */
    private $categoryId;


    /**
     * @return string
     */
    public function buildQuery()
    {
        return '';
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getUserAccountId()
    {
        return $this->userAccountId;
    }

    /**
     * @param int $userAccountId
     */
    public function setUserAccountId($userAccountId)
    {
        $this->userAccountId = $userAccountId;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartOn()
    {
        return $this->startOn;
    }

    /**
     * @param \DateTimeInterface $startOn
     */
    public function setStartOn($startOn)
    {
        $this->startOn = $startOn;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndOn()
    {
        return $this->endOn;
    }

    /**
     * @param \DateTimeInterface $endOn
     */
    public function setEndOn($endOn)
    {
        $this->endOn = $endOn;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
    }

    /**
     * @return int
     */
    public function getCategoryGroupId()
    {
        return $this->categoryGroupId;
    }

    /**
     * @param int $categoryGroupId
     */
    public function setCategoryGroupId($categoryGroupId)
    {
        $this->categoryGroupId = $categoryGroupId;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
}