<?php
namespace woojos\kontomierz;

/**
 * Class TransactionFactory
 * @package woojos\kontomierz
 */
class TransactionFactory
{
    /**
     * @param array $transaction
     * @return Transaction
     */
    public static function createFromJSONResponse(array $transaction)
    {
        return new Transaction(
            $transaction['id'],
            $transaction['user_account_id'],
            $transaction['category_id'],
            $transaction['currency_amount'],
            $transaction['currency_name'],
            \DateTime::createFromFormat('Y-m-d', $transaction['transaction_on']),
            $transaction['description'],
            $transaction['tag_string']
        );
    }

}