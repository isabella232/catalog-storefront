<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

use Magento\Framework\ObjectManagerInterface;

final class GroupedItemProductInfoMapper
{
    /**
     * @var string
     */
    private static $dtoClassName = GroupedItemProductInfoInterface::class;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
    * Set the data to populate the DTO
    *
    * @param mixed $data
    * @return $this
    */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
    * Build new DTO populated with the data
    *
    * @return GroupedItemProductInfo
    */
    public function build()
    {
        $dto = $this->objectManager->create(self::$dtoClassName);
        foreach ($this->data as $key => $valueData) {
            $this->setByKey($dto, $key, $valueData);
        }
        return $dto;
    }

    /**
    * Set the value of the key using setters.
    *
    * In case if the field is object, the corresponding Mapper would be create and DTO representing the field data
    * would be built
    *
    * @param GroupedItemProductInfo $dto
    * @param string $key
    * @param mixed $value
    */
    private function setByKey(GroupedItemProductInfo $dto, string $key, $value): void
    {
        switch ($key) {
            case "sku":
                $dto->setSku((string) $value);
                break;
            case "name":
                $dto->setName((string) $value);
                break;
            case "type_id":
                $dto->setTypeId((string) $value);
                break;
            case "url_key":
                $dto->setUrlKey((string) $value);
                break;
        }
    }
}