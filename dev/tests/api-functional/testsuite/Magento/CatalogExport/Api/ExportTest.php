<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogExport\Api;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * @magentoAppIsolation enabled
 */
class ExportTest extends WebapiAbstract
{
    /**
     * @var array
     */
    private $createServiceInfo;

    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \Magento\CatalogDataExporter\Model\Feed\Products
     */
    private $productsFeed;

    /**
     * @var string[]
     */
    private $attributesToCompare = [
        'sku',
        'name',
        'type',
        //'meta_description',
        //'meta_keyword',
        //'meta_title',
        'status',
        'tax_class_id',
        'created_at',
        'updated_at',
        'url_key',
        'visibility',
        //'weight',
        'currency',
        'displayable',
        'buyable',
        'attributes',
        'categories',
        'options',
        'in_stock',
        'low_stock',
        'url',
    ];

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->productsFeed = $this->objectManager->get(\Magento\CatalogDataExporter\Model\Feed\Products::class);

        $this->createServiceInfo = [
            'rest' => [
                'resourcePath' => '/V1/catalog-export/products',
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
            ],
            'soap' => [
                'service' => 'catalogExportApiProductRepositoryV1',
                'serviceVersion' => 'V1',
                'operation' => 'catalogExportApiProductRepositoryV1Get',
            ],
        ];
    }

    /**
     * @magentoApiDataFixture Magento/Catalog/_files/product_simple_with_custom_attribute.php
     */
    public function testExport()
    {
        $this->_markTestAsRestOnly('SOAP will be covered in another test');

        $this->reindex();

        /** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository */
        $productRepository = $this->objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $product = $productRepository->get('simple');

        $this->createServiceInfo['rest']['resourcePath'] .= '?ids[0]=' . $product->getId();
        $result = $this->_webApiCall($this->createServiceInfo, []);
        $this->assertProductsEquals($this->productsFeed->getFeedByIds([$product->getId()])['feed'], $result);
    }

    private function assertProductsEquals(array $expected, array $actual)
    {
        $size = sizeof($expected);
        for ($i = 0; $i < $size; $i++) {
            foreach ($this->attributesToCompare as $attribute) {
                $this->compareComplexValue(
                    $expected[$i][$this->snakeToCamelCase($attribute)],
                    $actual[$i][$attribute]
                );
            }
        }
    }

    private function compareComplexValue($expected, $actual)
    {
        if (is_array($expected)) {
            $this->assertEquals(
                sizeof($expected),
                sizeof($actual),
                'Expected and actual are of different size, expected '
                . json_encode($expected)
                . ', actual '
                . json_encode($actual)
                . '.'
            );
            foreach (array_keys($expected) as $key) {
                $snakeCaseKey = $this->camelToSnakeCase($key);
                $this->assertTrue(
                    isset($actual[$snakeCaseKey]),
                    $snakeCaseKey . 'doesn\'t exist, '
                    . json_encode($expected)
                    . ', actual '
                    . json_encode($actual)
                    . '.'
                );
                $this->compareComplexValue($expected[$key], $actual[$snakeCaseKey]);
            }
        } else {
            $this->assertEquals($expected, $actual);
        }
    }

    private function snakeToCamelCase($string)
    {
        $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        $string[0] = strtolower($string[0]);
        return $string;
    }

    private function camelToSnakeCase($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function reindex()
    {
        $appDir = dirname(Bootstrap::getInstance()->getAppTempDir());
        // phpcs:ignore Magento2.Security.InsecureFunction
        exec("php -f {$appDir}/bin/magento indexer:reindex");
    }

    /**
     * Test boolean attribute
     *
     * @magentoApiDataFixture Magento/Catalog/_files/one_product_simple_with_boolean_attribute.php
     */
    public function testBooleanAttribute()
    {
        $result = $this->getProductApiResult('simple_with_boolean');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult = [
                'attribute_code' => 'boolean_attribute',
                'type'  => 'boolean',
                'value' => [
                    [
                        'value' => 'yes'
                    ]
                ]
            ];

            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * Test Multiselect attribute
     *
     * @magentoApiDataFixture Magento/Catalog/_files/one_product_simple_with_multiselect_attribute.php
     */
    public function testMultiselectAttribute()
    {
        $result = $this->getProductApiResult('simple_with_multiselect');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult = [
                'attribute_code' => 'multiselect_attribute',
                'type'  => 'multiselect',
                'value' => [
                    [
                        'value' => 'Option 1',
                    ]
                ]
            ];

            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * Test image attribute
     *
     * @magentoApiDataFixture Magento/Catalog/_files/one_product_simple_with_image_attribute.php
     */
    public function testImageAttribute()
    {
        $result = $this->getProductApiResult('simple_with_image');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult = [
                'attribute_code' => 'image_attribute',
                'type'  => 'media_image',
                'value' => [
                    [
                        'value' => 'imagepath',
                    ]
                ]
            ];

            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * Test decimal attribute
     *
     * @magentoApiDataFixture Magento/Catalog/_files/one_product_simple_with_decimal_attribute.php
     */
    public function testDecimalAttribute()
    {
        $result = $this->getProductApiResult('simple_with_decimal');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult = [
                'attribute_code' => 'decimal_attribute',
                'type'  => 'price',
                'value' => [
                    [
                        'value' => '100.000000',
                    ]
                ]
            ];

            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * Test text editor attribute
     *
     * @magentoApiDataFixture Magento/Eav/_files/one_product_simple_with_text_editor_attribute.php
     */
    public function testTextEditorAttribute()
    {
        $result = $this->getProductApiResult('simple_with_text_editor');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult = [
                'attribute_code' => 'text_editor_attribute',
                'type'  => 'textarea',
                'value' => [
                    [
                        'value' => 'text Editor Attribute test',
                    ]
                ]
            ];
            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * Test Date time attribute
     *
     * @magentoApiDataFixture Magento/Catalog/_files/one_product_simple_with_date_attribute.php
     */
    public function testDateAttribute()
    {
        $result = $this->getProductApiResult('simple_with_date');
        if ($this->hasAttributeData($result)) {
            unset($result[0]['attributes'][0]['value'][0]['id']);
            $actualResult = $result[0]['attributes'][0];
            $expectedResult =  [
                'attribute_code' => 'date_attribute',
                'type'  => 'date',
                'value' => [
                    [
                        'value' => date('Y-m-d 00:00:00'),
                    ]
                ]
            ];

            $this->assertEquals($expectedResult, $actualResult);
        }
    }

    /**
     * @param $sku
     * @return array|bool|float|int|string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductApiResult($sku)
    {
        $this->_markTestAsRestOnly('SOAP will be covered in another test');
        $this->reindex();

        /** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository */
        $productRepository = $this->objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $product = $productRepository->get($sku);
        $this->createServiceInfo['rest']['resourcePath'] .= '?ids[0]=' . $product->getId();

        return $this->_webApiCall($this->createServiceInfo, []);
    }

    /**
     * Check if result has attribute data
     *
     * @param $result
     * @return bool
     */
    public function hasAttributeData($result)
    {
        if (isset($result[0]['attributes'][0]) &&
            $result[0]['attributes'][0]['value'][0]['id']) {

            return true;
        }

        return false;
    }
}
