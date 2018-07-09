<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Access;
use app\models\Note;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text:ntext',
            'name.username',
            'created',
            'edited',

            [
				'class' => 'yii\grid\ActionColumn',
				'buttons' => [
					'update' => function ($url, Note $model) {
						return Access::getAccessLevel($model) === Access::LEVEL_EDIT ? Html::a('Update', $url) : '';
					},
					'delete' => function ($url, Note $model) {
						return Access::getAccessLevel($model) === Access::LEVEL_EDIT ? Html::a('Delete', $url) : '';
					},
				],
			],
        ],
    ]); ?>
</div>
