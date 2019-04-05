<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 09:46
 */

namespace Audi2014\Schema;


class Value implements ValueInterface {

    public function __construct(array $params) {
        foreach (SchemaInterface::OPTIONS as $optionName) {
            if (isset($params[$optionName])) {
                $this->{$optionName} = $params[$optionName];
            } else {
                $this->{$optionName} = null;
            }
        }
    }

    /**
     * @param mixed $value
     * @param string $key
     * @param string $schemaName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function validate($value, string $key = '', string $schemaName = "_") {

        if ($value === null) {
            $value = $this->{SchemaInterface::OPTION_DEFAULT_VALUE} ?? null;
        }

        if($this->{SchemaInterface::OPTION_VALIDATE_FN}) {
            $fn = $this->{SchemaInterface::OPTION_VALIDATE_FN};
            $value = $fn($value);
        }

        if ($value !== null && $this->{SchemaInterface::OPTION_ENUM}) {
            if (!in_array($value, $this->{SchemaInterface::OPTION_ENUM})) {
                throw new \InvalidArgumentException(
                    "enum of `$schemaName`.`$key` does not contains value `$value`. ENUM: "
                    . json_encode($this->{SchemaInterface::OPTION_ENUM}) . ""
                );
            }
        }

        if ($value === null) {
            if ($this->{SchemaInterface::OPTION_NULLABLE}) {
                return null;
            } else {
                throw new \InvalidArgumentException("value of `$schemaName`.`$key` can't be null");
            }
        } else if (
            empty($value)
            && $this->{SchemaInterface::OPTION_NOT_EMPTY}
            && $this->{SchemaInterface::OPTION_TYPE} !== SchemaInterface::VALUE_TYPE_BOOL) {
            throw new \InvalidArgumentException("value of `$schemaName`.`$key` can't be empty");
        } else if (
            $this->{SchemaInterface::OPTION_TYPE} === SchemaInterface::VALUE_TYPE_STRING
            && $this->{SchemaInterface::OPTION_MIN} !== null
            && strlen($value) < $this->{SchemaInterface::OPTION_MIN}
        ) {
            throw new \InvalidArgumentException("min strlen of `$schemaName`.`$key` = {$this->{SchemaInterface::OPTION_MIN}}");
        } else if ($this->{SchemaInterface::OPTION_TYPE} === SchemaInterface::VALUE_TYPE_STRING
            && $this->{SchemaInterface::OPTION_MAX} !== null
            && strlen($value) > $this->{SchemaInterface::OPTION_MAX}
        ) {
            throw new \InvalidArgumentException("max strlen of `$schemaName`.`$key` = {$this->{SchemaInterface::OPTION_MAX}}");
        } else if ($this->{SchemaInterface::OPTION_MIN} !== null && $value < $this->{SchemaInterface::OPTION_MIN}) {
            throw new \InvalidArgumentException("min value of `$schemaName`.`$key` = {$this->{SchemaInterface::OPTION_MIN}}");
        } else if ($this->{SchemaInterface::OPTION_MAX} !== null && $value > $this->{SchemaInterface::OPTION_MAX}) {
            throw new \InvalidArgumentException("max value of `$schemaName`.`$key` = {$this->{SchemaInterface::OPTION_MAX}}");
        } else {
            if ($this->{SchemaInterface::OPTION_ARRAY}) {
                $result = [];
                if (!is_array($value)) {
                    $type = gettype($value);
                    throw new \InvalidArgumentException("value of `$schemaName`.`$key` is not array. $type given");
                }
                foreach ($value as $arrayKey => $arrayValue) {
                    $result[] = $this->_validateType($arrayValue, $schemaName, "$key->[$arrayKey]");
                }
                return $result;
            } else {
                return $this->_validateType($value, $schemaName, $key);
            }
//            switch ($this->{SchemaInterface::OPTION_TYPE}) {
//                case SchemaInterface::VALUE_TYPE_INT:
//                    return (int)$value;
//                    break;
//                case SchemaInterface::VALUE_TYPE_DOUBLE:
//                    return (double)$value;
//                    break;
//                case SchemaInterface::VALUE_TYPE_STRING:
//                    return (string)$value;
//                    break;
//                case SchemaInterface::VALUE_TYPE_BOOL:
//                    return (bool)$value;
//                    break;
//                case SchemaInterface::VALUE_TYPE_OBJECT:
//                    return $this->{SchemaInterface::OPTION_SUB_SCHEMA}->validate($value, $key);
//                    break;
//                case SchemaInterface::VALUE_TYPE_ARRAY:
//                    $result = [];
//                    foreach ($value as $arrayKey => $arrayValue) {
//                        $result[] = $this->{SchemaInterface::OPTION_SUB_SCHEMA}->validate($arrayValue, "$key->[$arrayKey]");
//                    }
//                    return $result;
//                    break;
//                default:
//                    throw new \InvalidArgumentException("invalid value_type: `{$this->{SchemaInterface::OPTION_TYPE}}` of `$schemaName`.$key");
//                    break;
//            }
        }
    }

    private function _validateType($value, $schemaName, $key) {
        switch ($this->{SchemaInterface::OPTION_TYPE}) {
            case SchemaInterface::VALUE_TYPE_INT:
                return (int)$value;
                break;
            case SchemaInterface::VALUE_TYPE_DOUBLE:
                return (double)$value;
                break;
            case SchemaInterface::VALUE_TYPE_STRING:
                return (string)$value;
                break;
            case SchemaInterface::VALUE_TYPE_BOOL:
                return (bool)$value;
                break;
            case SchemaInterface::VALUE_TYPE_OBJECT:
                //@class ObjectInterface
                if ($value !== null && !is_array($value)) {
                    $value = (array)$value;
                }
                if ($this->{SchemaInterface::OPTION_SUB_SCHEMA}) {
                    return $this->{SchemaInterface::OPTION_SUB_SCHEMA}->map($value, true);
                } else {
                    return $value;
                }
                break;
            default:
                throw new \InvalidArgumentException("invalid value_type: `{$this->{SchemaInterface::OPTION_TYPE}}` of `$schemaName`.$key");
                break;
        }
    }
}