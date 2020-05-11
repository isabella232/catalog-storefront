<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

final class ParentProduct implements ParentProductInterface
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $sku;
    /**
     * @var string
     */
    private $type;


    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setId(string $value): void
    {
        $this->id = $value;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string) $this->sku;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setSku(string $value): void
    {
        $this->sku = $value;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string) $this->type;
    }
    
    /**
     * @param string $value
     * @return void
     */
    public function setType(string $value): void
    {
        $this->type = $value;
    }
}