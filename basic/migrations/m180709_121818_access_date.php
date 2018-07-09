<?php

use yii\db\Migration;
use app\models\Access;

/**
 * Class m180709_121818_access_date
 */
class m180709_121818_access_date extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		parent::up();
		
		$this->addColumn(Access::tableName(), 'show_from', $this->dateTime());
		
		return true;
    }

    public function down()
    {
        parent::down();
		
		$this->dropColumn(Access::tableName(), 'show_from');

        return true;
    }
    
}
