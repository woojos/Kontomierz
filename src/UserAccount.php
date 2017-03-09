<?php
namespace woojos\kontomierz;

class UserAccount
{
    /** @var int */
    private $id;
    /** @var string */
    private $displayName;
    /** @var float */
    private $currencyBalance;
    /** @var string */
    private $currencyName;
    /** @var bool */
    private $isDefaultWallet;

    /**
     * @param int $id
     * @param string $displayName
     * @param float $currencyBalance
     * @param string $currencyName
     * @param bool $isDefaultWallet
     */
    public function __construct($id, $displayName, $currencyBalance, $currencyName, $isDefaultWallet)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->currencyBalance = $currencyBalance;
        $this->currencyName = $currencyName;
        $this->isDefaultWallet = $isDefaultWallet;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getCurrencyBalance()
    {
        return $this->currencyBalance;
    }

    /**
     * @param float $currencyBalance
     */
    public function setCurrencyBalance($currencyBalance)
    {
        $this->currencyBalance = $currencyBalance;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getCurrencyName()
    {
        return $this->currencyName;
    }

    /**
     * @return bool
     */
    public function isIsDefaultWallet()
    {
        return $this->isDefaultWallet;
    }
}