<?php

namespace core;

use yii\helpers\VarDumper;

class ContentFilter implements ContentFilterInterface
{
    const COMMENT_START = "/*";
    const COMMENT_END = "*/";

    public function filter($content)
    {
        if (empty($content)) {
            return "";
        }
        // filter JSON
        $content = $this->jsonFilter($content);
        $content = $this->commentsFilter($content);
        return $content;
    }

    private function jsonFilter($content)
    {
        $pattern = "/\{([^{}]+)\}/";
        preg_match_all($pattern, $content, $matches);
        if (count($matches[0])) {
            /** @var JsonTemplateWidget $templateWidget */
            $templateWidget = TemplateWidgetFactory::getTemplateWidget(TemplateWidget::JSON_WIDGET);
            foreach ( $matches[0] as $match ) {
                $widgetContent = $templateWidget->getWidgetContent($match);

                $content = str_replace($match, $widgetContent, $content);
            }
        }
        return $content;
    }

    private function commentsFilter($content)
    {
        $pattern = "~/\*.*\*/~";
        preg_match_all($pattern, $content, $matches);
        if (count($matches[0])) {
            foreach ( $matches[0] as $match ) {
                $content = str_replace($match, "", $content);
            }
        }
        return $content;
    }
}