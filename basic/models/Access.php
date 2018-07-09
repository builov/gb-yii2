<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $user
 * @property int $note
 */
class Access extends \yii\db\ActiveRecord
{
	
	const LEVEL_DENIED = 0;
	const LEVEL_VIEW = 1;
	const LEVEL_EDIT = 2;
	
	public static function getAccessLevel(Note $model)
    {
        $authorId = (int)$model->author;
		$currentUserId = (int)\Yii::$app->user->id;
		
		
		
		if ($authorId === $currentUserId) {			
			return self::LEVEL_EDIT;
		}
		
		$query = self::find()
			->forNote($model)
			->forUserId($currentUserId)
			->forDate();
			
		
			
		$accessNote = $query->one();
			
		//var_dump($model->id);
		//var_dump($currentUserId);
		//exit;
			
		if ($accessNote) {		
			return self::LEVEL_VIEW;
		}
		
		return self::LEVEL_DENIED;
    }
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'note'], 'required'],
			['show_from', 'date', 'format' => 'Y-m-d'],
            [['user', 'note'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'note' => 'Note',
			'show_from' => 'Show From',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessQuery(get_called_class());
    }
}
