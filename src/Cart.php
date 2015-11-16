<?php

namespace ark\yii\cart;

use ark\yii\cart\model\CartModel;
use ark\yii\cart\storage\StorageInterface;
use ark\yii\cart\exception\ClassNotFoundException;

/**
 * @inheritdoc
 *
 * @property \app\models\User|\yii\web\IdentityInterface|null $identity The identity object associated with the currently logged-in user. null is returned if the user is not logged in (not authenticated).
 */
class Cart extends \yii\base\Component
{
    /**
     * @var string
     */
    public $storageClass = 'ark\\yii\\cart\\storage\\SessionStorage';

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var CartModel
     */
    protected $cart;

    /**
     * @inheritdoc
     * @throws ClassNotFoundException
     */
    public function init()
    {
        $this->initializeCart();
    }

    /**
     * @throws ClassNotFoundException
     */
    private function initializeCart()
    {
        if (!class_exists($this->storageClass)) {
            throw new ClassNotFoundException(
                sprintf('Class "%s" are not found. Please checkout the correct namespace or autoload?', $this->storageClass)
            );
        }
        $this->storage = new $this->storageClass();
        $this->cart    = $this->storage->get();
    }

    public function addItem(ProductInterface $product, $quantity)
    {
        $this->cart->addItem($product, $quantity);
    }

    public function deleteItem(ProductInterface $product, $quantity)
    {
        $this->cart->updateItem($product, $quantity);
    }

    public function removeItem(ProductInterface $product)
    {
        $this->cart->deleteItem($product);
    }

    /**
     * @return boolean
     */
    public function destroy() {
        return $this->storage->destroy();
    }

    /**
     * @return CartModel
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }
}