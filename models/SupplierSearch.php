<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'validateIdInput'],
            [['name', 'code', 't_status'], 'safe'],
            [['id', 'name', 'code', 't_status'], 'filter', 'filter' => 'trim'],
            [['t_status'], 'in', 'range' => ['ok', 'hold']],
        ];
    }

    public function validateIdInput($attribute, $params, $validator)
    {
        $this->$attribute = trim($this->$attribute);
        $operator = $this->getOperator($this->$attribute);
        if ($operator) {
            $value = str_replace($operator, '', $this->$attribute);
            if ($value != (int)$value) {
                $this->addError($attribute, 'The ID search value only support integer');
            }
        }
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
        $query = Supplier::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);
        if ($this->id) {
            $this->id = trim($this->id);
        }
        $operator = $this->getOperator($this->id);
        if ($this->id) {
            $this->id = str_replace($operator, '', $this->id);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere([$operator, 'id', $this->id]);
        if ($operator && $operator !== '=') {
            $this->id = $operator . $this->id;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 't_status', $this->t_status]);

        return $dataProvider;
    }


}
