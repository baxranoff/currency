<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property string|null $rate
 * @property string|null $insert_dt
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [


            [['name'], 'string', 'max' => 255],
            [['rate'], 'string', 'max' => 50],
            [['insert_dt'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'rate' => 'Rate',
            'insert_dt' => 'Insert Dt',
        ];
    }

    /**
     * @return get all dataes with pagination
     */
    public function getCurrencies(){
        $query = Currency::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        return $data;
    }

    /**
     * @param $id
     * @return gets data with param $id
     */
    public function getCurrency($id){
        $res = $this::findOne(['id' => $id]);
        if($res != null)
            return $res;
        else
            return 'this id not found';

    }
}
