<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 27/07/2018
 * Time: 10:05
 */

namespace Audi2014\Schema;


class Dictionary implements DictionaryInterface {
    protected $keyValueSchema;
    protected $name;

    public function __construct(array $keyValueSchema, string $name = '') {
        $this->keyValueSchema = [];
        $this->name = $name;
        foreach ($keyValueSchema as $key => $value) {
            $this->keyValueSchema[$key] = new Value($value);
        }
    }

    /**
     * @param array|null $data
     * @param string $ownerPropertyName
     * @param bool $partial
     * @return array
     * @throws \InvalidArgumentException
     */
    public function validate(?array $data, string $ownerPropertyName = "", bool $partial = false): ?array {
        if ($data !== null) {
            $result = [];
            foreach ($this->keyValueSchema as $key => $valueSchema) {

                if (isset($data[$key])) {
                    $v = $data[$key];
                } else if($partial) {
                    continue;
                } else {
                    $v = null;

                }
                $result[$key] = $valueSchema->validate($v, $key, "({$this->name}$ownerPropertyName)");
            }
            return $result;
        } else {
            return null;
        }
    }
}