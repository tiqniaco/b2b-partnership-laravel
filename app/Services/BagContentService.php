<?php

namespace App\Services;

use App\Models\BagContent;
use App\Models\StoreProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;

class BagContentService
{
    /**
     * Attach bag contents to a store product
     *
     * @param StoreProduct $storeProduct
     * @param array $bagContentIds
     * @return bool
     * @throws Exception
     */
    public function attachBagContents(StoreProduct $storeProduct, array $bagContentIds): bool
    {
        try {
            $storeProduct->bagContents()->attach($bagContentIds);
            return true;
        } catch (QueryException $e) {
            Log::error('Failed to attach bag contents to store product', [
                'store_product_id' => $storeProduct->id,
                'bag_content_ids' => $bagContentIds,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to attach bag contents to the store product');
        }
    }

    /**
     * Detach bag contents from a store product
     *
     * @param StoreProduct $storeProduct
     * @param array $bagContentIds
     * @return bool
     * @throws Exception
     */
    public function detachBagContents(StoreProduct $storeProduct, array $bagContentIds): bool
    {
        try {
            $storeProduct->bagContents()->detach($bagContentIds);
            return true;
        } catch (QueryException $e) {
            Log::error('Failed to detach bag contents from store product', [
                'store_product_id' => $storeProduct->id,
                'bag_content_ids' => $bagContentIds,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to detach bag contents from the store product');
        }
    }

    /**
     * Sync bag contents for a store product
     *
     * @param StoreProduct $storeProduct
     * @param array $bagContentIds
     * @return bool
     * @throws Exception
     */
    public function syncBagContents(StoreProduct $storeProduct, array $bagContentIds): bool
    {
        try {
            $storeProduct->bagContents()->sync($bagContentIds);
            return true;
        } catch (QueryException $e) {
            Log::error('Failed to sync bag contents for store product', [
                'store_product_id' => $storeProduct->id,
                'bag_content_ids' => $bagContentIds,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to sync bag contents for the store product');
        }
    }

    /**
     * Get all bag contents for a store product
     *
     * @param StoreProduct $storeProduct
     * @return array
     * @throws Exception
     */
    public function getBagContents(StoreProduct $storeProduct): array
    {
        try {
            return $storeProduct->bagContents->toArray();
        } catch (Exception $e) {
            Log::error('Failed to get bag contents for store product', [
                'store_product_id' => $storeProduct->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to retrieve bag contents for the store product');
        }
    }

    /**
     * Get all store products for a bag content
     *
     * @param BagContent $bagContent
     * @return array
     * @throws Exception
     */
    public function getStoreProducts(BagContent $bagContent): array
    {
        try {
            return $bagContent->storeProducts->toArray();
        } catch (Exception $e) {
            Log::error('Failed to get store products for bag content', [
                'bag_content_id' => $bagContent->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to retrieve store products for the bag content');
        }
    }

    /**
     * Validate if bag content exists
     *
     * @param int $bagContentId
     * @return bool
     * @throws ModelNotFoundException
     */
    public function validateBagContent(int $bagContentId): bool
    {
        try {
            BagContent::findOrFail($bagContentId);
            return true;
        } catch (ModelNotFoundException $e) {
            Log::error('Bag content not found', [
                'bag_content_id' => $bagContentId,
                'error' => $e->getMessage()
            ]);
            throw new ModelNotFoundException('Bag content not found');
        }
    }

    /**
     * Validate if store product exists
     *
     * @param int $storeProductId
     * @return bool
     * @throws ModelNotFoundException
     */
    public function validateStoreProduct(int $storeProductId): bool
    {
        try {
            StoreProduct::findOrFail($storeProductId);
            return true;
        } catch (ModelNotFoundException $e) {
            Log::error('Store product not found', [
                'store_product_id' => $storeProductId,
                'error' => $e->getMessage()
            ]);
            throw new ModelNotFoundException('Store product not found');
        }
    }
} 