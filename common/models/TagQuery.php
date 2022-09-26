<?php

namespace common\models;

use paulzi\nestedsets\NestedSetsQueryTrait;

class TagQuery extends \yii\db\ActiveQuery
{
    use NestedSetsQueryTrait;
}
