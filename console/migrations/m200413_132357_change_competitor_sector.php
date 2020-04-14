<?php

use cnd\core\components\Migration;

/**
 * Class m200413_132357_change_competitor_sector
 */
class m200413_132357_change_competitor_sector extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->safeOperation(function () {
            $this->removeIndexForeignKey('competitor_flexible.sector_id');
            $this->removeIndexForeignKey('competitor_packaging.sector_id');
            $this->removeIndexForeignKey('competitor_masterbatch.sector_id');
        });

        $this->addColumn('{{%competitor_flexible}}', 'sector', $this->string());
        $this->addColumn('{{%competitor_masterbatch}}', 'sector', $this->string());
        $this->addColumn('{{%competitor_packaging}}', 'sector', $this->string());

        Yii::$app->db->createCommand('INSERT INTO mpk_data_list SELECT 0, p.name, NULL, 30, s.created_at, s.updated_at FROM `mpk_sector` as s, `mpk_portfolio` as p WHERE s.portfolio_id = p.id')
            ->execute();
    }
/*

UPDATE `mpk_competitor_flexible`
INNER JOIN (SELECT s.id, p.name FROM `mpk_sector` as s, `mpk_portfolio` as p WHERE s.portfolio_id = p.id) as D
ON
`mpk_competitor_flexible`.sector_id=D.id
SET `mpk_competitor_flexible`.sector = D.name

UPDATE `mpk_competitor_masterbatch`
INNER JOIN (SELECT s.id, p.name FROM `mpk_sector` as s, `mpk_portfolio` as p WHERE s.portfolio_id = p.id) as D
ON
`mpk_competitor_masterbatch`.sector_id=D.id
SET `mpk_competitor_masterbatch`.sector = D.name

UPDATE `mpk_competitor_packaging`
INNER JOIN (SELECT s.id, p.name FROM `mpk_sector` as s, `mpk_portfolio` as p WHERE s.portfolio_id = p.id) as D
ON
`mpk_competitor_packaging`.sector_id=D.id
SET `mpk_competitor_packaging`.sector = D.name

 */
    /**
     * {@inheritdoc}
     *
     */
    public function safeDown()
    {

        $this->safeOperation(function () {
            $this->createIndexForeignKey('competitor_flexible.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_packaging.sector_id', 'sector.id');
            $this->createIndexForeignKey('competitor_masterbatch.sector_id', 'sector.id');
        });

        $this->dropColumn('{{%competitor_flexible}}', 'sector');
        $this->dropColumn('{{%competitor_masterbatch}}', 'sector');
        $this->dropColumn('{{%competitor_packaging}}', 'sector');

        Yii::$app->db->createCommand('DELETE FROM mpk_data_list WHERE type=30')
            ->execute();
        return true;
    }


}
