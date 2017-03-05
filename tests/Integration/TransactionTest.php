<?php
namespace woojos\Kontomierz\Tests\Integration;

use woojos\Kontomierz\Transaction;
use woojos\Kontomierz\TransactionQuery;

/**
 * Class TransactionTest
 * @package woojos\Kontomierz\Tests\Integration
 */
class TransactionTest extends TestCaseBase
{

    /** @var int */
    private $userAccountId = 688430;

    /**
     * @test
     */
    public function shouldCreateTransaction()
    {
        $transaction = new Transaction(
            0,
            $this->userAccountId,
            $this->getFirstCategoryId(),
            100,
            'PLN',
            new \DateTime(),
            'Nazwa transakcji'
        );
        $this->kontomierzClient->createTransaction($transaction);
    }

    /**
     * @return int
     */
    private function getFirstCategoryId()
    {
        $response = $this->httpClient->get(self::URL . 'categories.json?api_key=' . $this->apiKey . '&=direction=withdrawal&in_wallet=true');
        $responseInArray = json_decode($response->getBody(), true);
        return $responseInArray['category_groups'][0]['categories'][0]['id'];
    }

    /**
     * @test
     */
    public function shouldGetTransactionList()
    {
        $transactionQuery = new TransactionQuery();
        $this->kontomierzClient->getTransactionList($transactionQuery);
    }

}