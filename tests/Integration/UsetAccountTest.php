<?php
namespace woojos\kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use woojos\kontomierz\KontomierzClientException;
use woojos\kontomierz\UserAccount;

/**
 * Class UserAccountTest
 * @package woojos\Kontomierz\Tests\Integration
 */
class UserAccountTest extends TestCaseBase
{

    public function setUp()
    {
        $httpClient = new Client();
        $response = $httpClient->get(self::URL . 'user_accounts.json?api_key=' . $this->apiKey);
        $accounts = json_decode($response->getBody(), true);

        foreach ($accounts as $a) {
            if (1 != $a['user_account']['is_default_wallet']) {
                $httpClient->delete(self::URL . 'user_accounts/'.$a['user_account']['id'].'/destroy_wallet.json?api_key=' . $this->apiKey);
            }
        }
    }

    /**
     * @test
     */
    public function shouldGetUserAccounts()
    {
        $ret = $this->kontomierzClient->getUserAccountList();
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

        $this->createUserAccount(new UserAccount(0, $name1, 1001, 'PLN', false));
        $userAccount = $this->getUserAccountByName($name1);
        $userAccount->setDisplayName($name2);
        $userAccount->setCurrencyBalance(99);

        $this->kontomierzClient->updateUserAccount($userAccount);
        $updatedUserAccount = $this->getUserAccountByName($name2);
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
        $this->createUserAccount(new UserAccount(0, 'xyz', 1001, 'PLN', false));
        $userAccount = $this->getUserAccountByName('xyz');

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

    private function createUserAccount(UserAccount $userAccount)
    {
        $this->httpClient->post(
            self::URL . 'user_accounts/create_wallet.json?api_key=' . $this->apiKey,
            [
                'form_params' => [
                    'user_account[user_name]' => $userAccount->getDisplayName(),
                    'user_account[currency_balance]' => $userAccount->getCurrencyBalance(),
                    'user_account[currency_name]' => $userAccount->getCurrencyName(),
                    'user_account[liquid]' => 1,

                ]
            ]
        );
    }

    /**
     * @param string $name
     * @return UserAccount
     * @throws \Exception
     */
    private function getUserAccountByName($name)
    {
        $response = $this->httpClient->get(self::URL . 'user_accounts.json?api_key=' . $this->apiKey);
        $arrayResponse = json_decode($response->getBody(), true);

        foreach ($arrayResponse as $row) {
            if ($name == $row['user_account']['display_name']) {
                return new UserAccount(
                    $row['user_account']['id'],
                    $row['user_account']['display_name'],
                    $row['user_account']['currency_balance'],
                    $row['user_account']['currency_name'],
                    1 == $row['user_account']['is_default_wallet']
                );
            }
        }

        throw new \Exception('TestHelper: User Account not found.');
    }

}