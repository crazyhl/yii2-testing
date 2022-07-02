<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ExportSupplierForm
 */
class ExportSupplierForm extends Model
{
    public $exportFields;
    public $ids;
    public $exportAllMatch;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['exportFields', 'ids'], 'required'],
            [['exportFields'], 'each', 'rule' => ['in', 'range' => ['id', 'code', 'name', 't_status']]],
            [['exportAllMatch'], 'integer'],
            [['exportAllMatch'], 'in', 'range'=> [0, 1]],
        ];
    }
}
