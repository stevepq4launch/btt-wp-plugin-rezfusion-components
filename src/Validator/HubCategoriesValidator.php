<?php

namespace Rezfusion\Validator;

class HubCategoriesValidator implements ValidatorInterface
{
    private $errors = [];

    private function processItems($categories, $callback): void
    {
        if (empty($categories)) {
            return;
        }
        foreach ($categories as $category) {
            $callback($category);
            foreach ($category->values as $categoryValue) {
                $callback($categoryValue);
            }
        }
    }

    private function checkIdsDuplicates($categories): void
    {
        $ids = [];
        $this->processItems($categories, function ($item) use (&$ids) {
            if (!empty($id = $item->id)) {
                (in_array($id, $ids))
                    ? $this->errors[] = sprintf("Found ID duplicate: %s.", $id)
                    : $ids[] = $id;
            }
        });
    }

    private function checkIdsArePresent($categories): void
    {
        $this->processItems($categories, function ($item) {
            if (!isset($item->id) || empty($item->id))
                $this->errors[] = sprintf("Invalid/unknown ID for %s category.", $item->name);
        });
    }

    public function validate($categories): bool
    {
        $this->errors = [];
        $this->checkIdsArePresent($categories);
        $this->checkIdsDuplicates($categories);
        return !boolval($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
