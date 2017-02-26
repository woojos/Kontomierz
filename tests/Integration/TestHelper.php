<?php
namespace woojos\Kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use woojos\Kontomierz\UserAccount;

/**
 * Class TestHelper
 * @package woojos\Kontomierz\Tests
 */
class TestHelper
{
    const URL = 'https://kontomierz.pl/k4/';

    /** @var string */
    private $apiKey;
    /** @var Client */
    private $httpClient;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new Client();
    }


    public function createUserAccount(UserAccount $userAccount)
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
    public function getUserAccountByName($name)
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