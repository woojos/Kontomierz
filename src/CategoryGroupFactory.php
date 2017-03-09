<?php
namespace woojos\kontomierz;

/**
 * Class CategoryGroupFactory
 * @package woojos\Kontomierz
 */
class CategoryGroupFactory
{

    /**
     * @param string $response
     * @return CategoryGroup[]
     */
    public static function createFromJSONResponse($response)
    {
        $responseInArray = json_decode($response, true);
        $groups = [];

        foreach ($responseInArray['category_groups'] as $groupArray) {

            $categories = [];
            foreach ($groupArray['categories'] as $categoryArray) {
                $categories[] = new Category($categoryArray['id'], $categoryArray['name']);
            }

            $groups[] = new CategoryGroup($groupArray['id'], $groupArray['name'], $categories);
        }
        return $groups;
    }

}