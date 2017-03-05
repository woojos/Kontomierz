<?php
namespace woojos\Kontomierz;

/**
 * Class KontomierzClientException
 * @package woojos\Kontomierz
 */
class KontomierzClientException extends \Exception
{
    const CREATE_USER_ACCOUNT_CODE = 1100;
    const UPDATE_USER_ACCOUNT_CODE = 1101;
    const DELETE_USER_ACCOUNT_CODE = 1102;

    const CREATE_TRANSACTION_CODE = 1200;
    const UPDATE_TRANSACTION_CODE = 1201;
    const DELETE_TRANSACTION_CODE = 1202;

    const GET_CATEGORIES_CODE = 1300;

    /**
     * @param \Exception $e
     * @return KontomierzClientException
     */
    public static function createUserAccountFailed(\Exception $e)
    {
        return new self('Create user account failed. ' . $e->getMessage(), self::CREATE_USER_ACCOUNT_CODE, $e);
    }

    /**
     * @param \Exception $e
     * @return KontomierzClientException
     */
    public static function updateUserAccountFailed(\Exception $e)
    {
        return new self('Update user account failed. ' . $e->getMessage(), self::UPDATE_USER_ACCOUNT_CODE, $e);
    }

    /**
     * @param \Exception $e
     * @return KontomierzClientException
     */
    public static function deleteUserAccountFailed(\Exception $e)
    {
        return new self('Delete user account failed. ' . $e->getMessage(), self::DELETE_USER_ACCOUNT_CODE, $e);
    }

    /**
     * @param \Exception $e
     * @return KontomierzClientException
     */
    public static function getCategoriesFailed(\Exception $e)
    {
        return new self('Get categories failed. ' . $e->getMessage(), self::GET_CATEGORIES_CODE, $e);
    }

    /**
     * @param \Exception $e
     * @return KontomierzClientException
     */
    public static function createTransactionFailed(\Exception $e)
    {
        return new self('Create transaction failed. ' . $e->getMessage(), self::CREATE_TRANSACTION_CODE, $e);
    }

}