<?php

namespace ark\yii\cart\storage;

interface StorageInterface
{
    const HASH = '_ark_cart_key';

    public function set($cart);

    public function get();

    public function destroy();

}