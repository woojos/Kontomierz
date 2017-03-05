<?php
namespace woojos\Kontomierz\Tests\Integration;

use woojos\Kontomierz\CategoryGroup;

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