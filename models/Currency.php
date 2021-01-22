<?php

namespace app\models;

use Yii;

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

}
