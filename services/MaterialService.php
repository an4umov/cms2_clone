<?php

namespace services;


use common\models\Material;

class MaterialService
{
    /**
     * @return array|Material[]
     */
    public function lastNews()
    {
        return Material::find()->where(['type_id' => Material::TYPE_NEWS])->limit(4)->orderBy('created_at DESC')->all();
    }
}