<?php

namespace ark\yii\cart\model;

use ark\yii\cart\storage\StorageInterface;
use Yii;
use DateTime;
use yii\base\Model;
use ark\yii\cart\event\ChangeCartEvent;
use ark\yii\cart\ProductInterface;

class CartModel extends Model
{
    const EVENT_CART_UPDATED = 'cart_item_updated';

    /**
     * @var integer
     */
    public $total_item;

    /**
     * @var integer
     */
    public $total_quantity;

    /**
     * @var float
     */
    public $total_price;

    /**
     * @var float
     */
    public $total_original_price;

    /**
     * @var float
     */
    public $discount;

    /**
     * @var string
     */
    public $expires_at;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * @var CartItemModel[] array
     */
    public $items = [];

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->storage = Yii::$app->cart->getStorage();

    }

    public function init()
    {
        $this->expires_at = (new DateTime('+4 hours'))->format('Y-m-d H:i:s');
        $this->created_at = (new DateTime())->format('Y-m-d H:i:s');
        $this->on(self::EVENT_CART_UPDATED,  [$this, 'afterCartUpdated']);
    }

    /**
     * @param ProductInterface $product
     * @param integer $quantity
     */
    public function addItem(ProductInterface $product, $quantity)
    {
        $itemHash = $this->generateHash($product);

        if (array_key_exists($itemHash, $this->items)) {
            /** @var CartItemModel $item */
            $item = $this->items[$itemHash];
            $item->quantity = $item->quantity + $quantity;
        } else {
            $item = new CartItemModel();
            $item->product_id = $product->getId();
            $item->name = $product->getName();
            $item->total_price = $product->getPrice();
            $item->total_original_price = $product->getOriginalPrice();
            $item->quantity = $quantity;
            $this->items[$itemHash] = $item;
        }

        $this->trigger(self::EVENT_CART_UPDATED);
    }

    /**
     * @param ProductInterface $product
     * @param $quantity
     */
    public function updateItem(ProductInterface $product, $quantity)
    {
        $itemHash = $this->generateHash($product);

        if (array_key_exists($itemHash, $this->items)) {
            $item = $this->items[$itemHash];
            $item->quantity = $quantity;
        }

        $this->trigger(self::EVENT_CART_UPDATED);
    }

    /**
     * @param ProductInterface $product
     */
    public function deleteItem(ProductInterface $product)
    {
        $itemHash = $this->generateHash($product);

        if (array_key_exists($itemHash, $this->items)) {
            unset($this->items[$itemHash]);
        }

        $this->trigger(self::EVENT_CART_UPDATED);
    }

    /**
     * @param ProductInterface $product
     * @return string
     */
    protected function generateHash($product) {
        return md5($product->getIdentifier());
    }

    /**
     * @param ChangeCartEvent $event
     */
    protected function afterCartUpdated($event)
    {
        $this->total_item = count($this->items);
        $this->total_quantity = 0;
        $this->total_price = (float) 0;
        $this->total_original_price = (float) 0;

        /**
         * @var string $key
         * @var CartItemModel $item
         */
        foreach ($this->items as $key => $item) {
            $this->total_quantity = $this->total_quantity + $item->quantity;
            $this->total_price = $this->total_price + ($item->total_price * $item->quantity);
            $this->total_original_price = $this->total_original_price + ($item->total_original_price * $item->quantity);
        }

        $this->updated_at = (new DateTime())->format('Y-m-d H:i:s');
    }
}