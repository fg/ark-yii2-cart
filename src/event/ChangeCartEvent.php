<?php

namespace ark\yii\cart\event;

use yii\base\Event;
use ark\yii\cart\ProductInterface;

class ChangeCartEvent extends Event
{
    /**
     * @var ProductInterface
     */
    public $product;

    /**
     * @var integer
     */
    public $qty;
}