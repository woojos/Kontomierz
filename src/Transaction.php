<?php
namespace woojos\kontomierz;

/**
 * Class Transaction
 * @package woojos\Kontomierz
 */
class Transaction
{
    const DIRECTION_WITHDRAWAL = 'withdrawal';
    const DIRECTION_DEPOSIT = 'deposit';
    const DIRECTION_ALL = 'all';

    /** @var int */
    private $id;
    /** @var int */
    private $userAccountId;
    /** @var int */
    private $categoryId;
    /** @var float */
    private $currencyAmount;
    /** @var string */
    private $currencyName;
    /** @var \DateTimeInterface */
    private $transactionOn;
    /** @var string */
    private $name;
    /** @var string */
    private $tagString;

    /**
     * @param int $id
     * @param int $userAccountId
     * @param int $categoryId
     * @param float $currencyAmount
     * @param string $currencyName
     * @param \DateTimeInterface $transactionOn
     * @param string $name
     * @param string $tagString
     */
    public function __construct($id, $userAccountId, $categoryId, $currencyAmount, $currencyName, \DateTimeInterface $transactionOn, $name, $tagString = '')
    {
        $this->id = $id;
        $this->userAccountId = $userAccountId;
        $this->categoryId = $categoryId;
        $this->currencyAmount = $currencyAmount;
        $this->currencyName = $currencyName;
        $this->transactionOn = $transactionOn;
        $this->name = $name;
        $this->tagString = $tagString;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserAccountId()
    {
        return $this->userAccountId;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return float
     */
    public function getCurrencyAmount()
    {
        return $this->currencyAmount;
    }

    /**
     * @return string
     */
    public function getCurrencyName()
    {
        return $this->currencyName;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTransactionOn()
    {
        return $this->transactionOn;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTagString()
    {
        return $this->tagString;
    }

}