<?php
namespace woojos\Kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use woojos\Kontomierz\KontomierzClient;
use PHPUnit\Framework\TestCase;
use woojos\Kontomierz\KontomierzClientException;
use woojos\Kontomierz\UserAccount;

class KontomierzClientTest extends TestCase
{
    /** @var string  */
    private $apiKey = 'RC7p1N8vU7JLxVV72l3hdcMP3hj7pgR90qRfG4sGV8HEZdPvrnyvb5sTBJWt0HQH';
    /** @var KontomierzClient */
    private $kontomierzClient;
    /** @var TestHelper */
    private $testHelper;

    public function setUp()
    {
        $httpClient = new Client();
        $response = $httpClient->get('https://kontomierz.pl/k4/user_accounts.json?api_key=' . $this->apiKey);
        $accounts = json_decode($response->getBody(), true);

        foreach ($accounts as $a) {
            if (1 != $a['user_account']['is_default_wallet']) {
                $httpClient->delete('https://kontomierz.pl/k4/user_accounts/'.$a['user_account']['id'].'/destroy_wallet.json?api_key=' . $this->apiKey);
            }
        }
    }

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->kontomierzClient = new KontomierzClient(new Client(), $this->apiKey);
        $this->testHelper = new TestHelper($this->apiKey);
    }

    /**
     * @test
     */
    public function shouldGetUserAccounts()
    {
        $ret = $this->kontomierzClient->getUserAccounts();
        self::assertEquals(1, count($ret));
    }

    /**
     * @test
     */
    public function shouldCreateUserAccount()
    {
        $userAccount = new UserAccount(0, 'Test Wallet', 1001, 'PLN', false);
        $this->kontomierzClient->createUserAccount($userAccount);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCurrencyInvalid()
    {
        $userAccount = new UserAccount(0, 'Test Wallet', 1001, 'XXX', false);
        $this->expectException(KontomierzClientException::class);
        $this->expectExceptionCode(KontomierzClientException::CREATE_USER_ACCOUNT_CODE);
        $this->kontomierzClient->createUserAccount($userAccount);
    }

    /**
     * @test
     */
    public function shouldUpdateUserAccount()
    {
        $name1 = 'Test Wallet 1';
        $name2 = 'Test Wallet 2';

        $this->testHelper->createUserAccount(new UserAccount(0, $name1, 1001, 'PLN', false));
        $userAccount = $this->testHelper->getUserAccountByName($name1);
        $userAccount->setDisplayName($name2);
        $userAccount->setCurrencyBalance(99);

        $this->kontomierzClient->updateUserAccount($userAccount);
        $updatedUserAccount = $this->testHelper->getUserAccountByName($name2);
        $this->assertEquals($userAccount->getDisplayName(), $updatedUserAccount->getDisplayName());
        $this->assertEquals(99, $updatedUserAccount->getCurrencyBalance());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUserAccountNotFoundWhileUpdating()
    {
        $this->expectException(KontomierzClientException::class);
        $this->expectExceptionCode(KontomierzClientException::UPDATE_USER_ACCOUNT_CODE);
        $this->kontomierzClient->updateUserAccount(new UserAccount(1, 'xyz', 1001, 'PLN', false));
    }

    /**
     * @test
     */
    public function shouldDeleteUserAccount()
    {
        $this->testHelper->createUserAccount(new UserAccount(0, 'xyz', 1001, 'PLN', false));
        $userAccount = $this->testHelper->getUserAccountByName('xyz');

        $this->kontomierzClient->deleteUserAccount($userAccount);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUserAccountNotFoundWhileDeleting()
    {
        $this->expectException(KontomierzClientException::class);
        $this->expectExceptionCode(KontomierzClientException::DELETE_USER_ACCOUNT_CODE);
        $this->kontomierzClient->deleteUserAccount(new UserAccount(1, 'xyz', 1001, 'PLN', false));
    }

}