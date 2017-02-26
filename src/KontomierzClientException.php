<?php
namespace woojos\Kontomierz;

/**
 * Class KontomierzClientException
 * @package woojos\Kontomierz
 */
class KontomierzClientException extends \Exception
{
    const CREATE_USER_ACCOUNT_CODE = 1000;
    const UPDATE_USER_ACCOUNT_CODE = 1001;
    const DELETE_USER_ACCOUNT_CODE = 1001;

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

}