<?php


namespace console\controllers;


use common\models\Material;
use common\models\Menu;
use common\models\Tag;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\VarDumper;

class PumpController extends Controller
{
    public function actionGo()
    {
        $a = 3; $n = 5;

        //// TAGS /////
        $oldDb = \Yii::$app->db1;
        $db = \Yii::$app->db;

        $tags = (new Query())->select(['tags.*'])
            ->from('tags')
            ->all($oldDb);

        foreach ($tags as & $ot) {
            $tag = new Tag();
            $tag->name = $ot['name'];
            $tag->save();
            $ot['new_id'] = (int)$tag->id;
        }

        $tmp = [];
        foreach ($tags as $ot) {
            $tmp[$ot['id']] = $ot;
        }

        $tags = $tmp;
        //// MATERIALS /////
        $mm = [];
        $materials = (new Query())->select(['articles.*', 'article_to_tag.tag_id'])
            ->from('articles')
            ->leftJoin('article_to_tag', 'article_to_tag.article_id = articles.id')
            ->all($oldDb);

        foreach ($materials as $om) {
            $m = new Material();
            $m->title = $om['title'];
            $m->alias = $om['url_key'];
            $m->content = $om['content'];
            $m->status = Material::STATUS_PUBLISHED;
            $m->preview = $om['announce_image'];

            $m->type_id = (int)$om['tag_id'] === $a
                ? $m->type_id = Material::TYPE_ACTION
                : (int)$om['tag_id'] === $n ? $m->type_id = Material::TYPE_NEWS : $m->type_id = Material::TYPE_ARTICLE;
            $m->save();
            $mm[(int)$om['id']] = $m->id;
        }

        //// ARTICLE_TAG_RELATIONS  ////////
        $ttm = (new Query())->select('*')
            ->from('article_to_tag')
            ->all($oldDb);

        foreach ($ttm as $t) {
            if (array_key_exists((int)$t['tag_id'], $tags) && array_key_exists((int)$t['article_id'], $mm)) {
                $db->createCommand()->insert('tag_material', [
                    'tag_id' => $tags[(int)$t['tag_id']]['new_id'],
                    'material_id' => $mm[(int)$t['article_id']],
                ])->execute();
            }
        }

        /// MENU ///
        $menus = (new Query())->select(['menu_items.*', 'tags.id as tag_id'])->from('menu_items')
            ->innerJoin('tags_to_menu_items', 'tags_to_menu_items.menu_item_id = menu_items.id')
            ->innerJoin('tags', 'tags_to_menu_items.tag_id = tags.id')
            ->all($oldDb);

        foreach ($menus as $item) {

            $mi = new Menu();
            $mi->title = $item['title'];
            $mi->name = $item['title'];
            $mi->makeRoot();

            $materials = Material::find()->innerJoin('tag_material', 'tag_material.material_id = material.id')
                ->where(['tag_material.tag_id' => $tags[(int)$item['tag_id']]['new_id']])->all();
            /// MENU RELATIONS///
            foreach ($materials as $material) {
                $db->createCommand()->insert('menu_material', [
                    'menu_id' => $mi->id,
                    'material_id' => $material->id,
                ])->execute();
            }

        }

    }


    public function actionClear()
    {
        (new Query())->createCommand()->delete('tag_material')->execute();
        (new Query())->createCommand()->delete('menu_material')->execute();
        (new Query())->createCommand()->delete('material')->execute();
        (new Query())->createCommand()->delete('tag')->execute();
        (new Query())->createCommand()->delete('menu')->execute();
    }
}