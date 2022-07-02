<?php

namespace app\commands;

use app\models\Supplier;
use Faker\Factory;
use yii\console\ExitCode;

class SeedController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 500; $i++) {
            $supplier = new Supplier();
            $supplier->name = $faker->name;
            $supplier->code = $faker->randomLetter() . $faker->randomLetter() . $faker->randomLetter(); //$faker->numerify('###');
            $supplier->t_status = $faker->randomNumber() % 3 == 0 ? 'HOLD' : 'OK';
            $supplier->insert();
        }

        return ExitCode::OK;

    }

}
