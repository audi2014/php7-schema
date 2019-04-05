<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 10:51
 */

namespace Audi2014\Schema;

class BaseSchema extends Dictionary {
    const TYPE_STRING = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_STRING,
        SchemaInterface::OPTION_DEFAULT_VALUE => "",
    ];
    const TYPE_STRING_NOT_EMPTY = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_STRING,
        SchemaInterface::OPTION_NOT_EMPTY => true,
    ];
    const TYPE_NULL_STRING = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_STRING,
        SchemaInterface::OPTION_NULLABLE => true,
    ];
    const TYPE_INT = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_INT,
    ];
    const TYPE_NULL_INT = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_INT,
        SchemaInterface::OPTION_NULLABLE => true,
    ];
    const TYPE_BOOL = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_BOOL,
        SchemaInterface::OPTION_DEFAULT_VALUE => false,
    ];

    const TYPE_NULL_BOOL = [
        SchemaInterface::OPTION_TYPE => SchemaInterface::VALUE_TYPE_BOOL,
        SchemaInterface::OPTION_NULLABLE => true,
    ];


    protected function willMap(array $data, bool $validate): array {
        return $data;
    }

    protected function didMap(array $data, bool $validate): array {
        return $data;
    }

    public function map(
        ?array $data,
        bool $validate = true,
        bool $partial = false
    ): ?array {
        if ($data === null) return null;
        $data = $this->willMap($data, $validate);
        if ($validate)
            $data = parent::validate($data, "", $partial);
        $data = $this->didMap($data, $validate);
        return $data;
    }
}