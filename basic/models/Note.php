<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notes".
 *
 * @property int $id
 * @property string $text
 * @property string $author
 * @property string $created
 * @property string $edited
 *
 * @property User $name
 * @property Access[] $accesses
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['created', 'edited'], 'safe'],
            [['author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'author' => 'Author',
            'created' => 'Created',
            'edited' => 'Edited',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NotesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotesQuery(get_called_class());
    }
	
	//returns ActiveQuery
	public function getAccess()
	{
		return $this->hasMany(Access::class, ['note' => 'id']);
	}
	
	//returns ActiveQuery
	public function getName()
	{
		return $this->hasOne(User::class, ['id' => 'author']);
	}
	
	public function beforeSave($insert)
	{
		$result = parent::beforeSave($insert);
		
		if (!$this->author) {
			$this->author = \Yii::$app->user->id;
		}
		
		return $result;
	}
}
