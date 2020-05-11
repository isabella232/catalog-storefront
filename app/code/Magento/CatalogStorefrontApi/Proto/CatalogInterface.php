<?php
# Generated by the protocol buffer compiler (spiral/php-grpc). DO NOT EDIT!
# source: catalog.proto

namespace Magento\CatalogStorefrontApi\Proto;

use Spiral\GRPC;

interface CatalogInterface extends GRPC\ServiceInterface
{
    // GRPC specific service name.
    public const NAME = "magento.catalogStorefrontApi.proto.Catalog";

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ProductsGetRequest $in
    * @return ProductsGetResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function GetProducts(GRPC\ContextInterface $ctx, ProductsGetRequest $in): ProductsGetResult;

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ImportProductsRequest $in
    * @return ImportProductsResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ImportProducts(GRPC\ContextInterface $ctx, ImportProductsRequest $in): ImportProductsResponse;
}