<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogMessageBroker\Model;

use Magento\CatalogExport\Event\Data\Entity;

/**
 * Fetch categories data
 */
interface FetchCategoriesInterface
{
    /**
     * Fetch categories data
     *
     * @param Entity[] $entities
     * @param string $scope
     *
     * @return array
     */
    public function execute(array $entities, string $scope): array;
}
