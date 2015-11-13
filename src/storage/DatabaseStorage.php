<?php

namespace ark\yii\cart\storage;

use Yii;
use yii\base\Object;
use ark\yii\cart\exception\UnsupportedStorage;

class DatabaseStorage extends Object implements StorageInterface
{
    public function set($cart)
    {

    }

    public function get()
    {
        throw new UnsupportedStorage(
            sprintf('Unsupported "%s" storage class.', __CLASS__)
        );
    }

    public function destroy()
    {

    }
}