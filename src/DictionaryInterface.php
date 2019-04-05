<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 09:21
 */

namespace Audi2014\Schema;


interface DictionaryInterface {

    /**
     * @param array|null $data
     * @param string $ownerPropertyName
     * @param bool $partial
     * @return array|null
     * @throws \InvalidArgumentException
     */
    public function validate(?array $data, string $ownerPropertyName = "", bool $partial = false): ?array;
}