<?php

namespace ark\yii\cart\storage;

use Yii;
use yii\base\Object;
use ark\yii\cart\model\CartModel;

class SessionStorage extends Object implements StorageInterface
{
    public function set($cart)
    {
        Yii::$app->session->set(self::HASH, $cart);
    }

    public function get()
    {
        if (!Yii::$app->session->has(self::HASH)) {
            Yii::$app->session->set(self::HASH, new CartModel());
        }

        return Yii::$app->session->get(self::HASH);
    }

    public function destroy()
    {
        return Yii::$app->session->remove(self::HASH);
    }
}