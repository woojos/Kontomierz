<?php
namespace woojos\kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use woojos\kontomierz\KontomierzClientException;
use woojos\kontomierz\Transaction;
use woojos\kontomierz\TransactionQuery;

/**
 * Class TransactionTest
 * @package woojos\Kontomierz\Tests\Integration
 */
class TransactionTest extends TestCaseBase
{

    /** @var int */
    private $userAccountId = 688430;
    /** @var int */
    private $depositCategoryId = 7618017;
    /** @var int  */
    private $withdrawalCategoryId = 7591674;

    public function setUp()
    {
        $httpClient = new Client();
        $response = $httpClient->get('https://kontomierz.pl/k4/money_transactions.json?user_account_id=688430&direction=all&start_on=2017-01-01&end_on=2017-04-01&api_key=' . $this->apiKey);
        $transactions = json_decode($response->getBody(), true);

        foreach ($transactions as $t) {
            $httpClient->delete('https://kontomierz.pl/k4/money_transactions/'.$t['money_transaction']['id'].'.json?api_key=' . $this->apiKey);
        }
    }

    /**
     * @test
     */
    public function shouldCreateWithdrawalTransaction()
    {
        $transaction = new Transaction(
            0,
            $this->userAccountId,
            $this->withdrawalCategoryId,
            -100,
            'PLN',
            \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-20 00:00:00'),
            'Nazwa transakcji'
        );
        $createdTransaction = $this->kontomierzClient->createTransaction($transaction);

        self::assertEquals($transaction->getCurrencyAmount(), $createdTransaction->getCurrencyAmount());
        self::assertEquals('2017-01-20', $createdTransaction->getTransactionOn()->format('Y-m-d'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenAddWithdrawalTransactionToDepositCategory()
    {
        $transaction = new Transaction(
            0,
            $this->userAccountId,
            $this->depositCategoryId,
            -100,
            'PLN',
            \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-20 00:00:00'),
            'Nazwa transakcji'
        );

        self::expectException(KontomierzClientException::class);
        self::expectExceptionCode(KontomierzClientException::CREATE_TRANSACTION_CODE);

        $this->kontomierzClient->createTransaction($transaction);
    }

    /**
     * @test
     */
    public function shouldCreateDepositTransaction()
    {
        $transaction = new Transaction(
            0,
            $this->userAccountId,
            $this->depositCategoryId,
            100,
            'PLN',
            \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-20 00:00:00'),
            'Nazwa transakcji'
        );
        $createdTransaction = $this->kontomierzClient->createTransaction($transaction);

        self::assertEquals($transaction->getCurrencyAmount(), $createdTransaction->getCurrencyAmount());
        self::assertEquals('2017-01-20', $createdTransaction->getTransactionOn()->format('Y-m-d'));
    }

    /**
     * @test
     */
    public function shouldGetTransactionList()
    {
        $transactionQuery = new TransactionQuery();
        $transactionQuery->setUserAccountId($this->userAccountId);
        $transactionQuery->setDirection(Transaction::DIRECTION_ALL);
        $transactionQuery->setStartOn(\DateTime::createFromFormat('Y-m-d', '2017-01-01'));
        $transactionQuery->setEndOn(\DateTime::createFromFormat('Y-m-d', '2017-04-01'));

        $transactionCollection = $this->kontomierzClient->getTransactionList($transactionQuery);
        self::assertEquals(0, count($transactionCollection));

        $this->httpClient->post(
            self::URL . 'money_transactions.json?api_key=' . $this->apiKey,
            ['form_params' => [
                'money_transaction[user_account_id]' => $this->userAccountId,
                'money_transaction[category_id]' => $this->withdrawalCategoryId,
                'money_transaction[currency_amount]' => 123,
                'money_transaction[currency_name]' => 'PLN',
                'money_transaction[direction]' => Transaction::DIRECTION_WITHDRAWAL,
                'money_transaction[name]' => 'test',
                'money_transaction[transaction_on]' => '2017-01-20',
                'money_transaction[client_assigned_id]' => time(),
                 ]
            ]
        );

        $transactionCollection = $this->kontomierzClient->getTransactionList($transactionQuery);
        self::assertEquals(1, count($transactionCollection));

    }

}