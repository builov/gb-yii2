<?php

use yii\db\Migration;

/**
 * Class m180704_144409_table_access
 */
class m180704_144409_table_access extends Migration
{
  

    public function up()
    {
		$this->execute('CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `note` (`note`);
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
');
    }

    public function down()
    {
        $this->dropTable('access');
    }
}
