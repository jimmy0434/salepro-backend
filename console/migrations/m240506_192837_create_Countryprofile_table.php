<?php



use cnd\core\components\Migration;

/**
 * Handles the creation of table `{{%Countryprofile}}`.
 */
class m240506_192837_create_Countryprofile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country_profile}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name' => $this->string(),
            'year' => $this->string(),
            'search_id' => $this->integer(),

        ]);

        $this->createTable('{{%country_profile_country}}', [
            'id' => $this->primaryKey(),
            'country_profile_id' => $this->integer(),
            'country' => $this->string(),

        ]);

        $this->createTable('{{%country_profile_region}}', [
            'id' => $this->primaryKey(),
            'country_profile_id' => $this->integer(),
            'region' => $this->string(),

        ]);

        $this->safeOperation(function () {
            $this->createIndexForeignKey('country_profile_country.country_profile_id','country_profile.id');
            $this->createIndexForeignKey('country_profile_region.country_profile_id','country_profile.id');
          
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country_profile}}');
    }
}
