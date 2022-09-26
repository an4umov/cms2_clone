<?php

namespace core;

use yii\helpers\VarDumper;

/**
 * Class JsonTemplateWidget
 */
class JsonTemplateWidget extends TemplateWidget
{
    /**
     * @param $source
     * @return mixed
     */
    public function getWidgetContent($source)
    {
        $params = json_decode($source, true);
        if (is_null($params)) {
            return $this->emptyStrategy($source);
        }
        return $this->renderWidget($params);
    }
}