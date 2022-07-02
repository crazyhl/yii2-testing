<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $t_status
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_status'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
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
            'code' => 'Code',
            't_status' => 'T Status',
        ];
    }

    public function getOperator($qryString){
        $operator =  '=';
        if ($qryString) {
            switch ($qryString){
                case strpos($qryString,'>=') === 0:
                    $operator = '>=';
                    break;
                case strpos($qryString,'>') === 0:
                    $operator = '>';
                    break;
                case strpos($qryString,'<=') === 0:
                    $operator = '<=';
                    break;
                case strpos($qryString,'<') === 0:
                    $operator = '<';
                    break;
                default:
                    $operator =  '=';
                    break;
            }
        }

        return $operator;
    }
}
