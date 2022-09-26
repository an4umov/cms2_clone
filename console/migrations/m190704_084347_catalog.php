<?php

use yii\db\Migration;

/**
 * Class m190704_084347_catalog
 */
class m190704_084347_catalog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'level' => $this->tinyInteger(),
            'is_product' => $this->tinyInteger()->notNull(),
            'parent_code' => $this->string(),
            'order' => $this->integer()->notNull(),
            'code' => $this->string(),
            'name' => $this->string()->notNull(),
            'full_name' => $this->string(),
            'description' => $this->text(),
            'title' => $this->string(),
            'tags' => $this->string(),
            'article' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('catalog-code-uniq', 'catalog', 'code', true);

        $db = \Yii::$app->db;
        $db->createCommand()->insert('catalog', [
            'level' => 1,
            'is_product' => 0,
            'parent_code' => '',
            'order' => 1,
            'code' => 'KAT0015001',
            'name' => 'Discovery sport',
            'full_name' => 'Discovery sport',
            'description' => 'Discovery sport',
            'title' => 'Discovery sport',
            'tags' => 'Land rover, ровер',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015001',
            'order' => 1,
            'code' => 'KAT0015002',
            'name' => ' Плановое техобслуживание',
            'full_name' => ' Плановое техобслуживание',
            'description' => ' Плановое техобслуживание для Discovery sport',
            'title' => ' Плановое техобслуживание',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015001',
            'order' => 2,
            'code' => 'KAT0015003',
            'name' => 'Аксессуары и тюнинг',
            'full_name' => 'Аксессуары и тюнинг',
            'description' => 'Аксессуары и тюнинг для Discovery sport',
            'title' => 'Аксессуары и тюнинг',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 3,
            'is_product' => 0,
            'parent_code' => 'KAT0015002',
            'order' => 1,
            'code' => 'KAT0015004',
            'name' => 'Discovery Sport Дизель',
            'full_name' => 'Discovery Sport Дизель',
            'description' => 'Discovery Sport Дизель для Discovery sport',
            'title' => 'Discovery Sport Дизель',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 3,
            'is_product' => 0,
            'parent_code' => 'KAT0015002',
            'order' => 2,
            'code' => 'KAT0015005',
            'name' => 'Discovery Sport Бензин',
            'full_name' => 'Discovery Sport Бензин',
            'description' => 'Discovery Sport Бензин для Discovery sport',
            'title' => 'Discovery Sport Бензин',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();

        $db->createCommand()->insert('catalog', [
            'level' => 4,
            'is_product' => 0,
            'parent_code' => 'KAT0015004',
            'order' => 1,
            'code' => 'KAT0015006',
            'name' => 'Обслуживание АКПП',
            'full_name' => 'Обслуживание АКПП',
            'description' => 'Обслуживание АКПП для Discovery sport',
            'title' => 'Обслуживание АКПП',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 4,
            'is_product' => 0,
            'parent_code' => 'KAT0015004',
            'order' => 2,
            'code' => 'KAT0015007',
            'name' => 'Тормозные колодки и диски',
            'full_name' => 'Тормозные колодки и диски',
            'description' => 'Тормозные колодки и диски для Discovery sport',
            'title' => 'Тормозные колодки и диски',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 5,
            'is_product' => 1,
            'parent_code' => 'KAT0015007',
            'order' => 1,
            'code' => 'KAT0015008',
            'name' => 'Диск литой R18',
            'full_name' => 'Диск литой R18',
            'description' => 'Диск литой R18 для Discovery sport',
            'title' => 'Диск литой R18',
            'tags' => 'Диски, литье',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 5,
            'is_product' => 1,
            'parent_code' => 'KAT0015007',
            'order' => 2,
            'code' => 'KAT0015009',
            'name' => 'Диск литой R19',
            'full_name' => 'Диск литой R19',
            'description' => 'Диск литой R19 для Discovery sport',
            'title' => 'Диск литой R19',
            'tags' => 'Диски, литье',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();

        $db->createCommand()->insert('catalog', [
            'level' => 1,
            'is_product' => 0,
            'parent_code' => '',
            'order' => 2,
            'code' => 'KAT0015010',
            'name' => 'Range Rover Evoque',
            'full_name' => 'Range Rover Evoque',
            'description' => 'Range Rover Evoque',
            'title' => 'Range Rover Evoque',
            'tags' => 'Land rover, ровер, evoque',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 1,
            'is_product' => 0,
            'parent_code' => '',
            'order' => 3,
            'code' => 'KAT0015011',
            'name' => 'Range Rover Vogue',
            'full_name' => 'Range Rover Vogue',
            'description' => 'Range Rover Vogue',
            'title' => 'Range Rover Vogue',
            'tags' => 'Land rover, ровер, vogue',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();

        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015010',
            'order' => 1,
            'code' => 'KAT0015012',
            'name' => ' Плановое техобслуживание',
            'full_name' => ' Плановое техобслуживание',
            'description' => ' Плановое техобслуживание для Discovery Evoque',
            'title' => ' Плановое техобслуживание',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015010',
            'order' => 2,
            'code' => 'KAT0015013',
            'name' => 'Аксессуары и тюнинг',
            'full_name' => 'Аксессуары и тюнинг',
            'description' => 'Аксессуары и тюнинг для Discovery Evoque',
            'title' => 'Аксессуары и тюнинг',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();

        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015011',
            'order' => 1,
            'code' => 'KAT0015014',
            'name' => ' Плановое техобслуживание',
            'full_name' => ' Плановое техобслуживание',
            'description' => ' Плановое техобслуживание для Discovery Vogue',
            'title' => ' Плановое техобслуживание',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
        $db->createCommand()->insert('catalog', [
            'level' => 2,
            'is_product' => 0,
            'parent_code' => 'KAT0015011',
            'order' => 2,
            'code' => 'KAT0015015',
            'name' => 'Аксессуары и тюнинг',
            'full_name' => 'Аксессуары и тюнинг',
            'description' => 'Аксессуары и тюнинг для Discovery Vogue',
            'title' => 'Аксессуары и тюнинг',
            'tags' => '',
            'article' => '',
            'created_at' => 1555417288,
            'updated_at' => 1555417288,
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('catalog');
    }
}
