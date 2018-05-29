<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;

/**
 * Class DirectoryController
 *
 * @package console\controllers
 */
class DirectoryController extends Controller
{
    /**
     * @var array
     */
    private $directoriesAliases = [
        '@uploadPath',
    ];

    /**
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $existNewDir = false;

        foreach($this->directoriesAliases as $alias){

            if(!empty(Yii::$aliases[$alias])){

                $path = Yii::$aliases[$alias];

                if(!file_exists($path)){

                    $existNewDir = true;

                    if(!FileHelper::createDirectory($path, 0777)){
                        $this->stdout("Failed to create directory: '$path'\n");
                    } else {
                        $this->stdout("The directory was created successfully: '$path'\n");
                    }

                }
            }
        }

        if(!$existNewDir) {
            $this->stdout("No new directories found.\n");
        }

        return ExitCode::OK;
    }

}
