<?php

namespace ark\yii\cart\model;

use yii\base\Model;

class CartItemModel extends Model
{
    /**
     * @var integer
     */
    public $product_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $total_price;

    /**
     * @var integer
     */
    public $total_original_price;

    /**
     * @var integer
     */
    public $quantity;
}