<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 09:13
 */

namespace Audi2014\Schema;


interface ValueInterface {


    /**
     * @param mixed $value
     * @param string $key
     * @param string $schemaName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function validate($value, string $key = '', string $schemaName = "_");
}