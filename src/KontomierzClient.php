<?php
namespace woojos\kontomierz;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class KontomierzClient
 * @package woojos\Kontomierz
 */
class KontomierzClient
{

    const FORMAT = 'json';

    const URL = 'https://secure.kontomierz.pl/k4/';

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
    public function getUserAccountList()
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
                ['form_params' => $this->buildUserAccountRequestArray($userAccount)]
            );
        } catch (ClientException $e) {
            throw KontomierzClientException::createUserAccountFailed($e);
        }
    }

    /**
     * @param UserAccount $userAccount
     * @return array
     */
    private function buildUserAccountRequestArray(UserAccount $userAccount)
    {
        return [
            'user_account[user_name]' => $userAccount->getDisplayName(),
            'user_account[currency_balance]' => $userAccount->getCurrencyBalance(),
            'user_account[currency_name]' => $userAccount->getCurrencyName(),
            'user_account[liquid]' => 1
        ];
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
                ['form_params' => $this->buildUserAccountRequestArray($userAccount)]
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

    /**
     * @return array
     * @throws KontomierzClientException
     */
    public function getCategories()
    {
        try {
            $response = $this->httpClient->get(self::URL . 'categories.' . self::FORMAT . '?api_key=' . $this->apiKey . '&=direction=withdrawal&in_wallet=true');
            return CategoryGroupFactory::createFromJSONResponse($response->getBody()->getContents());
        } catch (ClientException $e) {
            throw KontomierzClientException::getCategoriesFailed($e);
        }
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws KontomierzClientException
     */
    public function createTransaction(Transaction $transaction)
    {
        try {
            $response = $this->httpClient->post(
                self::URL . 'money_transactions.' . self::FORMAT . '?api_key=' . $this->apiKey,
                ['form_params' => $this->buildTransactionRequestArray($transaction)]
            );
            $responseArray = json_decode($response->getBody()->getContents(), true);

            return TransactionFactory::createFromJSONResponse($responseArray['money_transaction']);
        } catch (ClientException $e) {
            throw KontomierzClientException::createTransactionFailed($e);
        }
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    private function buildTransactionRequestArray(Transaction $transaction)
    {
        $direction = $transaction->getCurrencyAmount() >= 0 ? Transaction::DIRECTION_DEPOSIT : Transaction::DIRECTION_WITHDRAWAL;

        return [
            'money_transaction[user_account_id]' => $transaction->getUserAccountId(),
            'money_transaction[category_id]' => $transaction->getCategoryId(),
            'money_transaction[currency_amount]' => $transaction->getCurrencyAmount(),
            'money_transaction[currency_name]' => $transaction->getCurrencyName(),
            'money_transaction[direction]' => $direction,
            'money_transaction[tag_string]' => $transaction->getTagString(),
            'money_transaction[name]' => $transaction->getName(),
            'money_transaction[transaction_on]' => $transaction->getTransactionOn()->format("Y-m-d"),
            'money_transaction[client_assigned_id]' => microtime(true),
        ];
    }

    /**
     * @param TransactionQuery $query
     * @throws KontomierzClientException
     */
    public function getTransactionList(TransactionQuery $query)
    {
        try {
            $url = self::URL . 'money_transactions.' . self::FORMAT . '?api_key=' . $this->apiKey . '&' . $query->buildQuery();
            $response = $this->httpClient->get($url);
            $responseInArray = json_decode($response->getBody()->getContents(), true);
            $collection = [];
            foreach ($responseInArray as $transaction) {
                $collection[] = TransactionFactory::createFromJSONResponse($transaction['money_transaction']);
            }
            return $collection;
        } catch (ClientException $e) {
            throw KontomierzClientException::getCategoriesFailed($e);
        }
    }
}



