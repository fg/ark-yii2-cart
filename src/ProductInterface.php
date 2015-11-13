<?php

namespace ark\yii\cart;

interface ProductInterface
{
    public function getIdentifier();

    public function getId();

    public function getName();

    public function getPrice();

    public function getOriginalPrice();

    public function getQuantity();
}