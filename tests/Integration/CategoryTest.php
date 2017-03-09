<?php
namespace woojos\kontomierz\Tests\Integration;

use woojos\kontomierz\CategoryGroup;

/**
 * Class CategoryTest
 * @package woojos\Kontomierz\Tests\Integration
 */
class CategoryTest extends TestCaseBase
{

    /**
     * @test
     */
    public function shouldGetCategories()
    {
        $ret = $this->kontomierzClient->getCategories();
        self::assertInstanceOf(CategoryGroup::class, $ret[0]);
    }

}