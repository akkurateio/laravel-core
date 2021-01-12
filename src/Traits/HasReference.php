<?php

namespace Akkurate\LaravelCore\Traits;

/**
 * Trait HasReference
 */
trait HasReference {

    /**
     * Used to generate Random and unique booking references
     * @param $length
     * @param $prefix
     * @param $suffix
     * @return string
     */
    public static function generateReference($length = 8, $prefix = '', $suffix = '') {

        $characters = config('reference.characters');
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $prefix.$string.$suffix;
    }

}
