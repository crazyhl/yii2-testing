<?php

namespace app\controllers;

use app\models\ExportSupplierForm;
use app\models\Supplier;
use app\models\SupplierSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $exportForm = new ExportSupplierForm();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'exportForm' => $exportForm,
        ]);
    }

    public function actionExport()
    {
        if (!$this->request->isPost) {
            print_r('非法请求');
            return;
        }
        $searchModel = new SupplierSearch();
        $exportForm = new ExportSupplierForm();
        $searchModel->load($this->request->post());
        $exportForm->load($this->request->post());
        if (!$searchModel->validate()) {
            return $this->redirect([
                'supplier/index',
                'SupplierSearch[id]' => $searchModel->id,
                'SupplierSearch[name]' => $searchModel->name,
                'SupplierSearch[code]' => $searchModel->code,
                'SupplierSearch[t_status]' => $searchModel->t_status,
            ]);
        }
        if (!$exportForm->validate()) {
            return $this->redirect([
                'supplier/index',
                'SupplierSearch[id]' => $searchModel->id,
                'SupplierSearch[name]' => $searchModel->name,
                'SupplierSearch[code]' => $searchModel->code,
                'SupplierSearch[t_status]' => $searchModel->t_status,
            ]);
        }

        $query = Supplier::find();
        $query->select($exportForm->exportFields);
        if ($exportForm->exportAllMatch) {
            // 根据条件获取全部
            $operator = $searchModel->getOperator($searchModel->id);
            if ($searchModel->id) {
                $searchModel->id = str_replace($operator, '', $searchModel->id);
            }
            $query->andFilterWhere([$operator, 'id', $searchModel->id]);
            if ($operator && $operator !== '=') {
                $searchModel->id = $operator . $searchModel->id;
            }

            $query->andFilterWhere(['like', 'name', $searchModel->name])
                ->andFilterWhere(['like', 'code', $searchModel->code])
                ->andFilterWhere(['like', 't_status', $searchModel->t_status]);

        } else {
            // 根据传入 id 获取数据
            $query->andWhere(['in', 'id', explode(',', $exportForm->ids)]);
        }

        $content = $this->export($query->all(), $exportForm->exportFields);

        return $this->response->sendContentAsFile($content, 'supplier-export--'.date('d-m-Y H-i').".csv", [
            'mimeType' => 'application/csv',
            'inline'   => false
        ]);
    }


    private function export($rows, $coldefs, $boolPrintRows = true, $separator = ',')
    {
        $endLine = "\r\n";
        $returnVal = '';

        if ($boolPrintRows) {
            $names = '';
            foreach ($coldefs as $col) {
                $names .= $col . $separator;
            }
            $names = rtrim($names, $separator);
            $returnVal .= $names . $endLine;
        }

        foreach ($rows as $row) {
            $r = '';
            foreach ($coldefs as $col) {
                if (isset($row->$col)) {
                    $val = $row->$col;
                    $r .= $val . $separator;
                }
            }
            $item = trim(rtrim($r, $separator)) . $endLine;
            $returnVal .= $item;

        }

        return $returnVal;
    }
}
