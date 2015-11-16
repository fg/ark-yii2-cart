<?php

namespace ark\yii\cart\event;

use yii\base\Event;
use ark\yii\cart\ProductInterface;

class CartActionEvent extends Event
{
    /**
     * @var ProductInterface $product
     */
    public $product;

    /**
     * @var
     */
    public $cart;
}