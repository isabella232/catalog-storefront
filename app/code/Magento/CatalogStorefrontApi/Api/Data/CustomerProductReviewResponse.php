<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

/**
 * Autogenerated description for CustomerProductReviewResponse class
 *
 * phpcs:disable Magento2.PHP.FinalImplementation
 * @SuppressWarnings(PHPMD)
 * @SuppressWarnings(PHPCPD)
 */
final class CustomerProductReviewResponse implements CustomerProductReviewResponseInterface
{

    /**
     * @var array
     */
    private $items;
    
    /**
     * @inheritdoc
     *
     * @return \Magento\CatalogStorefrontApi\Api\Data\ReadReviewInterface[]
     */
    public function getItems(): array
    {
        return (array) $this->items;
    }
    
    /**
     * @inheritdoc
     *
     * @param \Magento\CatalogStorefrontApi\Api\Data\ReadReviewInterface[] $value
     * @return void
     */
    public function setItems(array $value): void
    {
        $this->items = $value;
    }
}