<?php

namespace App\Helpers;

class FunctionsHelper
{
    public static function mapIterableToId($iterable, $idParamName='id'): array
    {
        $ret = [];

        if ($iterable) {
            foreach ($iterable as $item) {
                if (isset($item[$idParamName])) {
                    $ret[$item[$idParamName]] = $item;
                }
            }
        }

        return $ret;
    }
}
