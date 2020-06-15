<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: catalog.proto

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CatalogStorefrontApi\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>magento.catalogStorefrontApi.proto.ConfigurableOptionValue</code>
 *
 * phpcs:disable
 */
class ConfigurableOptionValue extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string value_index = 1;</code>
     */
    protected $value_index = '';
    /**
     * Generated from protobuf field <code>string label = 2;</code>
     */
    protected $label = '';
    /**
     * Generated from protobuf field <code>string default_label = 3;</code>
     */
    protected $default_label = '';
    /**
     * Generated from protobuf field <code>string store_label = 4;</code>
     */
    protected $store_label = '';
    /**
     * Generated from protobuf field <code>string use_default_value = 5;</code>
     */
    protected $use_default_value = '';
    /**
     * Generated from protobuf field <code>string attribute_id = 6;</code>
     */
    protected $attribute_id = '';
    /**
     * Generated from protobuf field <code>string product_id = 7;</code>
     */
    protected $product_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value_index
     *     @type string $label
     *     @type string $default_label
     *     @type string $store_label
     *     @type string $use_default_value
     *     @type string $attribute_id
     *     @type string $product_id
     * }
     */
    public function __construct($data = null)
    {
        \Magento\CatalogStorefrontApi\Metadata\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string value_index = 1;</code>
     * @return string
     */
    public function getValueIndex()
    {
        return $this->value_index;
    }

    /**
     * Generated from protobuf field <code>string value_index = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setValueIndex($var)
    {
        GPBUtil::checkString($var, true);
        $this->value_index = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string label = 2;</code>
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Generated from protobuf field <code>string label = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLabel($var)
    {
        GPBUtil::checkString($var, true);
        $this->label = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string default_label = 3;</code>
     * @return string
     */
    public function getDefaultLabel()
    {
        return $this->default_label;
    }

    /**
     * Generated from protobuf field <code>string default_label = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setDefaultLabel($var)
    {
        GPBUtil::checkString($var, true);
        $this->default_label = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string store_label = 4;</code>
     * @return string
     */
    public function getStoreLabel()
    {
        return $this->store_label;
    }

    /**
     * Generated from protobuf field <code>string store_label = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setStoreLabel($var)
    {
        GPBUtil::checkString($var, true);
        $this->store_label = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string use_default_value = 5;</code>
     * @return string
     */
    public function getUseDefaultValue()
    {
        return $this->use_default_value;
    }

    /**
     * Generated from protobuf field <code>string use_default_value = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setUseDefaultValue($var)
    {
        GPBUtil::checkString($var, true);
        $this->use_default_value = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string attribute_id = 6;</code>
     * @return string
     */
    public function getAttributeId()
    {
        return $this->attribute_id;
    }

    /**
     * Generated from protobuf field <code>string attribute_id = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setAttributeId($var)
    {
        GPBUtil::checkString($var, true);
        $this->attribute_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string product_id = 7;</code>
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Generated from protobuf field <code>string product_id = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setProductId($var)
    {
        GPBUtil::checkString($var, true);
        $this->product_id = $var;

        return $this;
    }
}