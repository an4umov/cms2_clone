<?php

namespace core;

use core\JsonTemplateWidget;

class TemplateWidgetFactory
{
    public static function getTemplateWidget($template)
    {
        if ($template === TemplateWidget::JSON_WIDGET) {
            return new JsonTemplateWidget();
        }
        return null;
    }
}