<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Access]].
 *
 * @see Access
 */
class AccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
	
	
	public function forNote($note)
    {
        $this->andWhere(['note' => $note->id]);
		return $this;
    }
	
	public function forUserId($userId)
    {
        $this->andWhere(['user' => $userId]);
		return $this;
    }
	
	public function forDate()
    {
        $date = date('Y-m-d');
		$this->andWhere([
			'or', 
			['<=', 'show_from', $date],
			['show_from' => null],
		]);
		return $this;
    }
}
