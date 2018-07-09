<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Note;

/**
 * NoteSearch represents the model behind the search form of `app\models\Note`.
 */
class NoteSearch extends Note
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['text', 'author', 'created', 'edited'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Note::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created' => $this->created,
            'edited' => $this->edited,
			'access.user' => $params['user'] ?? ''
        ]);
		
		$query->joinWith('access');

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'author', $this->author]);

        return $dataProvider;
    }
}
