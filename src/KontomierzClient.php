<?php
namespace woojos\Kontomierz;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class KontomierzClient
{

    const FORMAT = 'json';

    const URL = 'https://kontomierz.pl/k4/';

    /** @var string */
    private $apiKey;

    /** @var Client */
    private $httpClient;

    /**
     * @param Client $httpClient
     * @param string $apiKey
     */
    public function __construct(Client $httpClient, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
    }

    /**
     * @return UserAccount[]
     */
    public function getUserAccounts()
    {
        $response = $this->httpClient->get(self::URL . 'user_accounts.' . self::FORMAT . '?api_key=' . $this->apiKey);
        $arrayResponse = json_decode($response->getBody(), true);
        $userAccountList = [];

        foreach ($arrayResponse as $row) {
            $userAccountList[] = new UserAccount(
                $row['user_account']['id'],
                $row['user_account']['display_name'],
                $row['user_account']['currency_balance'],
                $row['user_account']['currency_name'],
                1 == $row['user_account']['is_default_wallet']
            );
        }

        return $userAccountList;
    }

    /**
     * @param UserAccount $userAccount
     * @throws KontomierzClientException
     */
    public function createUserAccount(UserAccount $userAccount)
    {
        try {
            $this->httpClient->post(
                self::URL . 'user_accounts/create_wallet.' . self::FORMAT . '?api_key=' . $this->apiKey,
                [
                    'form_params' => [
                        'user_account[user_name]' => $userAccount->getDisplayName(),
                        'user_account[currency_balance]' => $userAccount->getCurrencyBalance(),
                        'user_account[currency_name]' => $userAccount->getCurrencyName(),
                        'user_account[liquid]' => 1,

                    ]
                ]
            );
        } catch (ClientException $e) {
            throw KontomierzClientException::createUserAccountFailed($e);
        }
    }

    /**
     * @param UserAccount $userAccount
     * @throws KontomierzClientException
     */
    public function updateUserAccount(UserAccount $userAccount)
    {
        try {
            $this->httpClient->put(
                self::URL . 'user_accounts/' . $userAccount->getId() . '/update_wallet.' . self::FORMAT . '?api_key=' . $this->apiKey,
                [
                    'form_params' => [
                        'user_account[user_name]' => $userAccount->getDisplayName(),
                        'user_account[currency_balance]' => $userAccount->getCurrencyBalance(),
                        'user_account[currency_name]' => $userAccount->getCurrencyName(),
                        'user_account[liquid]' => 1,

                    ]
                ]
            );
        } catch (ClientException $e) {
            throw KontomierzClientException::updateUserAccountFailed($e);
        }
    }

    /**
     * @param UserAccount $userAccount
     * @throws KontomierzClientException
     */
    public function deleteUserAccount(UserAccount $userAccount)
    {
        try {
            $this->httpClient->delete(self::URL . 'user_accounts/' . $userAccount->getId() . '/destroy_wallet.' . self::FORMAT . '?api_key=' . $this->apiKey);
        } catch (ClientException $e) {
            throw KontomierzClientException::deleteUserAccountFailed($e);
        }
    }

}



