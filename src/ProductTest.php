<?php

namespace ark\yii\cart;

class ProductTest implements ProductInterface
{
    public function getIdentifier()
    {
        return 'test_12';
    }

    public function getId()
    {
        return 1;
    }

    public function getName()
    {
        return $this->getIdentifier();
    }

    public function getPrice()
    {
        return 10.5;
    }

    public function getOriginalPrice()
    {
        return 11;
    }

    public function getQuantity()
    {
        return rand(1,6);
    }
}