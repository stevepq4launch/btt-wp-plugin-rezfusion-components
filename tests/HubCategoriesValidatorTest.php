<?php

namespace Rezfusion\Tests;

use Rezfusion\Validator\HubCategoriesValidator;

class HubCategoriesValidatorTest extends BaseTestCase
{
    private function doValidateTest($categories, $expectedError = ''): void
    {
        $Validator = new HubCategoriesValidator();
        $Validator->validate($categories);
        $errors = $Validator->getErrors();
        $this->assertCount(1, $errors);
        $this->assertSame($expectedError, $errors[0]);
    }

    public function testValidateWithInvalidCategoryID(): void
    {
        $categories = json_decode(json_encode(
            [
                [
                    'id' => 1,
                    'values' => [
                        [
                            'name' => 'cat-1',
                            'id' => null
                        ]
                    ]
                ]
            ]
        ));
        $this->doValidateTest($categories, 'Invalid/unknown ID for cat-1 category.');
    }

    public function testValidateWithDuplicatedId(): void
    {
        $categories = json_decode(json_encode(
            [
                [
                    'id' => 1,
                    'values' => [
                        [
                            'name' => 'cat-1',
                            'id' => 1
                        ]
                    ]
                ]
            ]
        ));
        $this->doValidateTest($categories, 'Found ID duplicate: 1.');
    }
}
