<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Setting;

/**
 * Class m200508_082747_add_dashboard_link
 */
class m200508_082747_add_dashboard_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Setting::set('dashboard.link', 'http://indevcobi.indevcogroup.com/sense/app/9f63d74f-5ebf-4938-ad82-f17693ba002a');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {;
        return true;
    }

}
