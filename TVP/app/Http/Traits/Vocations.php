<?php

declare(strict_types=1);

namespace App\Http\Traits;

trait Vocations {

    public static function getAllVocationsById(): array
    {
        return array_keys(config('vocations'));
    }

    public static function getIdsByName(string $vocationName): array
    {
        $vocationIds = [];
        $vocationArrayKey = array_search($vocationName, array_column(config('vocations'), 'name'));
        if (is_bool($vocationArrayKey) && !$vocationArrayKey) {
            return [];
        }
        $vocation = config('vocations')[$vocationArrayKey];
        $vocationIds[] = $vocationArrayKey;
        if (isset($vocation['child_id'])) {
            foreach ($vocation['child_id'] as $vocationChild) {
                $vocationIds[] = $vocationChild;
            }
        }
        if (isset($vocation['parent_id'])) {
            foreach ($vocation['parent_id'] as $vocationParent) {
                $vocationIds[] = $vocationParent;
            }
        }
        return $vocationIds;
    }
}