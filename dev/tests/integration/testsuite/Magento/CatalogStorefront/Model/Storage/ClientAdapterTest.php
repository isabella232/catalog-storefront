<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogStorefront\Model\Storage;

use Magento\CatalogStorefront\Model\Storage\Client\ElasticsearchCommand;
use Magento\CatalogStorefront\Model\Storage\Client\ElasticsearchDataDefinitionAdapter;
use Magento\CatalogStorefront\Model\Storage\Client\ElasticsearchQuery;
use Magento\CatalogStorefront\Model\Storage\Data\DocumentFactory;
use Magento\CatalogStorefront\Model\Storage\Data\DocumentIteratorFactory;
use Magento\Integration\Api\AdminTokenServiceInterface;
use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use \Magento\Framework\ObjectManagerInterface;

/**
 * Class ClientAdapterTest
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ClientAdapterTest extends TestCase
{
    const SERVICE_NAME = 'catalogProductRepositoryV1';
    const SERVICE_VERSION = 'V1';
    const RESOURCE_PATH = '/V1/products';

    /** @var ObjectManagerInterface */
    private $objectManager;

    /**
     * @var State
     */
    private $state;

    /**
     * @var AdminTokenServiceInterface
     */
    private $adminTokens;

    /**
     * @var DocumentFactory
     */
    private $documentFactory;

    /**
     * @var DocumentIteratorFactory
     */
    private $documentIteratorFactory;

    /**
     * @var ElasticsearchDataDefinitionAdapter
     */
    private $storageDDL;

    /**
     * @var ElasticsearchQuery
     */
    private $storageQuery;

    /**
     * @var ElasticsearchCommand
     */
    private $storageCommand;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = Bootstrap::getObjectManager();
        $this->state = $this->objectManager->create(State::class);
        $this->storageDDL = $this->objectManager->create(ElasticsearchDataDefinitionAdapter::class);
        $this->storageQuery = $this->objectManager->create(ElasticsearchQuery::class);
        $this->storageCommand = $this->objectManager->create(ElasticsearchCommand::class);
        $this->adminTokens = Bootstrap::getObjectManager()->get(AdminTokenServiceInterface::class);
        $this->documentFactory = Bootstrap::getObjectManager()->get(DocumentFactory::class);
        $this->documentIteratorFactory = Bootstrap::getObjectManager()->get(DocumentIteratorFactory::class);

        $this->storageDDL->createDataSource($this->state->getCurrentDataSourceName(['scope']), []);
        $this->storageDDL->createEntity($this->state->getCurrentDataSourceName(['scope']), 'product', []);
        $this->storageDDL->createAlias($this->state->getAliasName(), $this->state->getCurrentDataSourceName(['scope']));
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->storageDDL->deleteDataSource($this->state->getCurrentDataSourceName(['scope']));
    }

    /**
     * @return void
     */
    public function testBulkInsert(): void
    {
        $productBuilder = $this->getSimpleProductData();
        $productBuilder['sku'] = 'test-sku-default-site-123';
        $productData = $productBuilder;

        $this->storageCommand->bulkInsert(
            $this->state->getAliasName(),
            'product',
            [$productData]
        );

        $entry = $this->storageQuery->getEntry(
            $this->state->getAliasName(),
            'product',
            $productBuilder['id'],
            ['sku']
        );

        $this->assertEquals($productData['sku'], $entry->getData('sku'));

        $entry = $this->storageQuery->getEntries(
            $this->state->getAliasName(),
            'product',
            [$productBuilder['id']],
            ['sku']
        )->current();

        $this->assertEquals($productData['sku'], $entry->getData('sku'));
    }

    /**
     * @expectedException \Magento\Framework\Exception\BulkException
     * @expectedExceptionMessage Error occurred while bulk insert
     */
    public function testBulkInsertWithWrongMappingType(): void
    {
        $productBuilder = $this->getSimpleProductData();
        $productBuilder['sku'] = 'test-sku-default-site-123';
        $productData = $productBuilder;

        // set test mapping
        $productData['random_mapping_type'] = 0;

        $this->storageCommand->bulkInsert(
            $this->state->getAliasName(),
            'product',
            [$productData]
        );

        $productData['random_mapping_type'] = 'text string';

        $this->storageCommand->bulkInsert(
            $this->state->getAliasName(),
            'product',
            [$productData]
        );
    }

    /**
     * @expectedException \Magento\Framework\Exception\NotFoundException
     * @expectedExceptionMessage 'product' type document with id '111' not found in index 'not_found_index'.
     */
    public function testNotFoundIndex()
    {
        $this->storageQuery->getEntry(
            'not_found_index',
            'product',
            111,
            ['sku']
        );
    }

    /**
     * @return void
     */
    public function testNotFoundItem()
    {
        $nonExistingId = 123123123;
        $item = $this->storageQuery->getEntries(
            $this->state->getAliasName(),
            'product',
            [$nonExistingId],
            ['sku']
        )->current();

        $this->assertEquals($nonExistingId, $item->getId());
        $this->assertNull($item->getData());
    }

    /**
     * @expectedException \Magento\Framework\Exception\RuntimeException
     * @expectedExceptionMessage Storage error
     */
    public function testStorageException()
    {
        $this->storageQuery->getEntries(
            $this->state->getAliasName(),
            'product',
            [],
            ['sku']
        )->current();
    }

    /**
     * Get Simple Product Data
     *
     * @return array
     */
    private function getSimpleProductData()
    {
        return [
            'id' => rand(),
            'sku' => uniqid('sku-', true),
            'name' => uniqid('name-', true),
            'visibility' => 4,
            'type_id' => 'simple',
            'price' => 3.62,
            'status' => 1,
            'attribute_set_id' => 4,
            'custom_attributes' => [
                ['attribute_code' => 'cost', 'value' => ''],
                ['attribute_code' => 'description', 'value' => 'Description'],
            ]
        ];
    }
}