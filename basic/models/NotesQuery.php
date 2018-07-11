<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Note]].
 *
 * @see Note
 */
class NotesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Note[]|array
     */
    public function all($db = null)
    {
        $key = 'notes_list';
		
		$cachedResult = \Yii::$app->cache->get($key);
		if ($cachedResult !== false) {
			return $cachedResult;
		}		
		
		$result = parent::all($db);
		
		\Yii::$app->cache->set($key, $result, 10);		
		
		return $result;
    }

    /**
     * {@inheritdoc}
     * @return Note|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
