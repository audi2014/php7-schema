<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 09:28
 */

namespace Audi2014\Schema;


interface SchemaInterface {
    const VALUE_TYPE_STRING = 'ts';
    const VALUE_TYPE_DOUBLE = 'td';
    const VALUE_TYPE_INT = 'ti';
    const VALUE_TYPE_BOOL = 'tb';
    const VALUE_TYPE_OBJECT = 'to';
//    const VALUE_TYPE_ARRAY = 'ta';
    const TYPES = [
        self::VALUE_TYPE_STRING,
        self::VALUE_TYPE_DOUBLE,
        self::VALUE_TYPE_INT,
        self::VALUE_TYPE_BOOL,
        self::VALUE_TYPE_OBJECT,
//        self::VALUE_TYPE_ARRAY,
    ];

    const OPTION_ARRAY = 'arr';
    const OPTION_MIN = 'min';
    const OPTION_MAX = 'max';
    const OPTION_TYPE = 'ot';
    const OPTION_NULLABLE = 'on';
    const OPTION_DEFAULT_VALUE = 'od';
    const OPTION_ENUM = 'oe'; // can be not null only if OPTION_TYPE is 10 - 13
    const OPTION_NOT_EMPTY = 'one'; // required if OPTION_TYPE is 14 - 15
    const OPTION_SUB_SCHEMA = 'oss'; // required if OPTION_TYPE is 16
    const OPTION_VALIDATE_FN = 'ovfn'; // optional function. can throw or return validated value

    const OPTIONS = [
        self::OPTION_ARRAY,
        self::OPTION_TYPE,
        self::OPTION_NULLABLE,
        self::OPTION_DEFAULT_VALUE,
        self::OPTION_ENUM,
        self::OPTION_NOT_EMPTY,
        self::OPTION_SUB_SCHEMA,
        self::OPTION_VALIDATE_FN,
        self::OPTION_MIN,
        self::OPTION_MAX,
    ];

    public function map(?array $data, bool $validate = true): ?array;


}