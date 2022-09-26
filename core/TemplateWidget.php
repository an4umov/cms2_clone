<?php

namespace core;

use backend\models\Template;
use common\models\Material;
use common\models\WidgetTemplate;
use yii\helpers\VarDumper;

/**
 * Class TemplateWidget
 * Суперкласс для рендеров.
 */
abstract class TemplateWidget
{
    const TEMPLATE_ELEMENT_PATTERN = "{%.%}";

    const JSON_WIDGET = 'Json';

    const RETURN_EMPTY  = 'empty';
    const RETURN_SOURCE = 'source';

    protected $ifSourceNullStrategy = self::RETURN_SOURCE;

    /**
     * @param $source
     * @return mixed
     */
    abstract public function getWidgetContent($source);

    /**
     * @param $source
     * @return string
     */
    protected function emptyStrategy($source)
    {
        if ($this->ifSourceNullStrategy === self::RETURN_SOURCE) {
            return $source;
        } else if ($this->ifSourceNullStrategy === self::RETURN_EMPTY) {
            return "";
        }
        return "";
    }

    /**
     * По полученному массиву решает какой виджет вернуть
     * @param array $params массив, получаемы рендером - подклассом в результате фильтрации и разбора контента
     * по определенному признаку
     * @return string результета в виде html
     */
    protected function renderWidget($params = [])
    {
        if (empty($params) || !isset($params['id'])) {
            return "";
        }

        $template = WidgetTemplate::findOne([
            'id' => $params['id']
        ]);

        if (is_null($template)) {
            return "";
        }

        $parent = Template::findOne([
            'alias' => $template->name
        ]);

        if (is_null($parent)) {
            return "";
        }

        if ($parent->type === Template::TYPE_FREE) {
            return $this->wrap($this->parseTemplateReplaced($template->content, $params), $template->name . "_" . $template->id);
        } else if ($parent->type === Template::TYPE_MATERIAL_PREVIEW){
            // тут надо наверное рендерить статичную вьюхуп
            $material = Material::findOne("id = {$params['material_id']}");
            if (!empty($material)) {
                return \Yii::$app->controller->renderPartial('new/materialsList', array( 'data' => $material ));
            }
            return "";
        }

        return "";
    }

    /**
     * Заменяет искомые пдстановки в шаблоне
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function parseTemplateReplaced($template = "", $params = [])
    {
        if (empty($template) || empty($params)) {
            return "";
        }

        $pattern = "/{%\\w+\\|[\\w\\s]+%}/u";
        preg_match_all($pattern, $template, $matches);
        foreach ($matches[0] as $match) {
            $keys = explode('|', ltrim(rtrim($match, "%}"), "{%"));
            $key = trim($keys[0]);
            if (array_key_exists($key, $params)) {
                $template = str_replace($match, $params[$key], $template);
            }
        }
        return $template;
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    protected function wrap($subject, $id = "", $cssClass = "")
    {
        if (empty($id)) {
            $id = uniqid();
        }
        $ID = !empty($id) ? " id=\"{$id}\"" : "";
        $class = !empty($cssClass) ? " class=\"{$cssClass}\"" : "";
        return "<div {$ID}{$class}>{$subject}</div>";
    }
}