<?php


namespace console\controllers;


use common\components\helpers\{ConsoleHelper, PlanFixHelper};
use common\models\{PlanfixContact, PlanfixPartner, PlanfixProjectTask};
use yii\console\{Controller, ExitCode};
use yii\helpers\{ArrayHelper, Json};

class PlanFixController extends Controller
{
    const BATCH_LIMIT = 100;

    public function actionContacts()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = 0;

        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials(PlanFixHelper::LOGIN, PlanFixHelper::PASSWORD);
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $totalPages = $pageCurrent = 1;
        $method = 'contact.getList';

        $contacts = $api->api($method, ['pageCurrent' => $pageCurrent, 'pageSize' => self::BATCH_LIMIT,]);
//        print_r($contacts);
//        exit(1);

        if (!empty($contacts[PlanFixHelper::KEY_DATA]['contacts']['contact'])) {
            $savedCount += $this->_processContacts($contacts[PlanFixHelper::KEY_DATA]['contacts']['contact']);
        }

        if (!empty($contacts[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT])) {
            $totalCount = (int) $contacts[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT];
            $totalPages = ceil($totalCount / self::BATCH_LIMIT);
            $rowsCount += (int) $contacts[PlanFixHelper::KEY_META][PlanFixHelper::KEY_COUNT];
        }

        while ($totalPages > $pageCurrent) {
            $pageCurrent++;
            $contacts = $api->api($method, ['pageCurrent' => $pageCurrent, 'pageSize' => self::BATCH_LIMIT,]);

            if (!empty($contacts[PlanFixHelper::KEY_DATA]['contacts']['contact'])) {
                $savedCount += $this->_processContacts($contacts[PlanFixHelper::KEY_DATA]['contacts']['contact']);
                $rowsCount += (int) $contacts[PlanFixHelper::KEY_META][PlanFixHelper::KEY_COUNT];

                ConsoleHelper::debug('Обработано '.$savedCount.' записей из '.$totalCount, $isConsole);
            }
        }

        ConsoleHelper::debug('Получено '.$rowsCount.' записей для таблицы '.PlanfixPartner::tableName(), $isConsole);
        ConsoleHelper::debug('Сохранено '.$savedCount.' записей в таблице '.PlanfixPartner::tableName(), $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @return int
     * @throws \common\components\helpers\PlanFixHelperException
     * @throws \yii\db\Exception
     */
    public function actionHandbooks()
    {
        ConsoleHelper::processPlanFixHandbooks(true);

        return ExitCode::OK;
    }

    public function actionProjects()
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        $isConsole = true;

        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials(PlanFixHelper::LOGIN, PlanFixHelper::PASSWORD);
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $allProjects = [];
        $totalPages = $pageCurrent = 1;
        $method = 'project.getList';
        $params = [
            'pageCurrent' => $pageCurrent,
            'pageSize' => self::BATCH_LIMIT,
//            'filters' => [
//                ['filter' => ['type' => 5105, 'operator' => 'equal', 'value' => 1, 'field' => 51256,],],
//            ],
        ];

        $projects = $api->api($method, $params);
//        print_r($projects);
//        exit;
        if (!empty($projects[PlanFixHelper::KEY_DATA]['projects']['project'])) {
            if ($projects[PlanFixHelper::KEY_META][PlanFixHelper::KEY_COUNT] === 1) {
                $allProjects = [$projects[PlanFixHelper::KEY_DATA]['projects']['project'],];
            } else {
                $allProjects = $projects[PlanFixHelper::KEY_DATA]['projects']['project'];
            }
        }

        if (!empty($projects[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT])) {
            $totalCount = (int) $projects[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT];
            $totalPages = ceil($totalCount / self::BATCH_LIMIT);
        }

        while ($totalPages > $pageCurrent) {
            $pageCurrent++;
            $params = [
                'pageCurrent' => $pageCurrent,
                'pageSize' => self::BATCH_LIMIT,
//                'filters' => [
//                    ['filter' => ['type' => 5105, 'operator' => 'equal', 'value' => 1, 'field' => 51256,],],
//                ],
            ];
            $projects = $api->api($method, $params);

            if (!empty($projects[PlanFixHelper::KEY_DATA]['projects']['project'])) {
                if ($projects[PlanFixHelper::KEY_META][PlanFixHelper::KEY_COUNT] === 1) {
                    $allProjects += [$projects[PlanFixHelper::KEY_DATA]['projects']['project'],];
                } else {
                    $allProjects += $projects[PlanFixHelper::KEY_DATA]['projects']['project'];
                }
            }
        }

        $savedCount = $this->_processProjects($allProjects, $db, $api);

        ConsoleHelper::debug('Сохранено '.$savedCount.' записей в таблице '.PlanfixProjectTask::tableName(), $isConsole);

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param array $contacts
     *
     * @return int
     */
    private function _processContacts(array $contacts) : int
    {
        $count = 0;
        foreach ($contacts as $contact) {
            $contactModel = PlanfixContact::find()->where(['planfix_id' => $contact['userid'],])->one();
            if (!$contactModel) {
                $contactModel = new PlanfixContact();
                $contactModel->planfix_id = (int)$contact['userid'];
            }

            $contactModel->name = $contact['name'];
            $contactModel->midName = $contact['midName'];
            $contactModel->lastName = $contact['lastName'];
            $contactModel->type = empty($contact['isCompany']) ? PlanfixPartner::TYPE_CONTACT : PlanfixPartner::TYPE_COMPANY;
            $customData = [];
            if (!empty($contact['customData']) && is_array($contact['customData'])) {
                foreach ($contact['customData'] as $customDatum) {
                    if (!empty($customDatum['customValue'])) {
                        $customData[] = [
                            'name' => $customDatum['customValue']['field']['name'],
                            'value' => !empty($customDatum['customValue']['value']) ? $customDatum['customValue']['value'] : null,
                        ];
                    }
                }
            }
            $contactModel->customData = $customData ? Json::encode($customData) : null;

            $phones = [];
            if (!empty($contact['phones']) && is_array($contact['phones'])) {
                foreach ($contact['phones'] as $customDatum) {
                    if (!empty($customDatum['phone'])) {
                        $phones[] = [
                            'number' => $customDatum['phone']['number'],
                            'type' => $customDatum['phone']['typeName'],
                        ];
                    }
                }
            }
            $contactModel->phones = $phones ? Json::encode($phones) : null;

            $contactModel->email = $contact['email'];
            $contactModel->address = $contact['address'];
            $contactModel->site = $contact['site'];
            $contactModel->skype = $contact['skype'];
            $contactModel->facebook = $contact['facebook'];
            $contactModel->telegram = $contact['telegramId'];
            $contactModel->instagram = null;
            $contactModel->vk = $contact['vk'];
            $contactModel->icq = $contact['icq'];
            $contactModel->description = $contact['description'];
            $contactModel->terms = null;

            if ($contactModel->save(false)) {
                $count++;
            } else {
                print_r($contactModel->getErrors());
            }
        }

        ConsoleHelper::debug('Обработано '.count($contacts).' записей, сохранено '.$count.' записей для таблицы '.PlanfixPartner::tableName(), true);

        return $count;
    }

    private function _getChildProjects($parentID, $projects)
    {
        $data = [];
        foreach ($projects as $project) {
            if (!empty($project['parent']['id']) && $project['parent']['id'] === $parentID) {
                $data[$project['id']] = $project;

                $data = ArrayHelper::merge($data, $this->_getChildProjects($project['id'], $projects));
            }
        }

        return $data;
    }

    /**
     * @param array         $projects
     * @param               $db
     * @param PlanFixHelper $api
     *
     * @return int
     * @throws \common\components\helpers\PlanFixHelperException
     * @throws \yii\db\Exception
     */
    private function _processProjects(array $projects, $db, PlanFixHelper $api) : int
    {
        $allCount = 0;

        $export = [];
        foreach ($projects as $project) {
            if (!empty($project['customData']['customValue']['field']['id']) && $project['customData']['customValue']['field']['id'] == PlanfixProjectTask::CUSTOM_VALUE_EXPORT_1C_ID) {
                if (!empty($project['customData']['customValue']['value'])) {
                    $export[$project['id']] = $project;

                    $childProjects = $this->_getChildProjects($project['id'], $projects);
                    if ($childProjects) {
                        $export = ArrayHelper::merge($export, $childProjects);
                    }
                }
            }
        }

        if ($export) {
            ConsoleHelper::truncateTable(PlanfixProjectTask::tableName(), $db, true);

            foreach ($export as $item) {
                $model = new PlanfixProjectTask();
                $model->planfix_id = (int) $item['id'];
                $model->type = PlanfixProjectTask::TYPE_PROJECT;
                if (!empty($item['parent']['id']) && isset($export[$item['parent']['id']])) {
                    $model->parent_id = (int) $item['parent']['id'];
                }
                $model->email = 'project+'.$model->planfix_id.'@lrru.planfix.ru';
                $model->title = trim($item['title']);
                $model->description = is_string($item['description']) ? trim($item['description']) : '';
                $model->status = $item['status'];
                $model->is_active = $item['status'] === PlanFixHelper::PROJECT_STATUS_ACTIVE;
                $model->favoriteData = Json::encode([]);
                $model->link = 'https://lrru.planfix.ru/project/'.$model->planfix_id;

                if ($model->save(false)) {
                    $allCount++;
                } else {
                    print_r($model->getErrors());
                }
            }

            ConsoleHelper::debug('Обработано '.count($projects).' записей, сохранено '.$allCount.' проектов для таблицы '.PlanfixProjectTask::tableName(), true);

            foreach ($export as $item) {
                $allTasks = [];
                $totalPages = $pageCurrent = 1;
                $method = 'task.getList';
                $count = 0;

                $tasks = $api->api($method, ['pageCurrent' => $pageCurrent, 'pageSize' => self::BATCH_LIMIT, 'project' => ['id' => $item['id'],],]);
                if (!empty($tasks[PlanFixHelper::KEY_DATA]['tasks']['task'])) {
                    $allTasks = $tasks[PlanFixHelper::KEY_DATA]['tasks']['task'];
                }

                if (!empty($tasks[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT])) {
                    $totalCount = (int) $tasks[PlanFixHelper::KEY_META][PlanFixHelper::KEY_TOTAL_COUNT];
                    $totalPages = ceil($totalCount / self::BATCH_LIMIT);
                }

                while ($totalPages > $pageCurrent) {
                    $pageCurrent++;
                    $tasks = $api->api($method, ['pageCurrent' => $pageCurrent, 'pageSize' => self::BATCH_LIMIT, 'project' => ['id' => $item['id'],],]);

                    if (!empty($tasks[PlanFixHelper::KEY_DATA]['tasks']['task'])) {
                        $allTasks += $tasks[PlanFixHelper::KEY_DATA]['tasks']['task'];
                    }
                }

                ConsoleHelper::debug('Получено '.count($allTasks).' задач для проекта #'.$item['id'], true);

                foreach ($allTasks as $task) {
                    $model = new PlanfixProjectTask();
                    $model->planfix_id = (int) $task['id'];
                    $model->type = PlanfixProjectTask::TYPE_TASK;
                    if (!empty($task['parent']['id'])) {
                        $model->parent_id = (int) $task['parent']['id'];
                    }
                    $model->email = 'task+'.$task['general'].'@lrru.planfix.ru';
                    $model->title = trim($task['title']);
                    $model->description = is_string($task['description']) ? trim($task['description']) : null;
                    $model->status = $task['status'];
                    $model->is_active = true;
                    $model->favoriteData = Json::encode([]);
                    $model->link = 'https://lrru.planfix.ru/task/'.$task['general'];

                    if ($model->save(false)) {
                        $count++;
                        $allCount++;
                    } else {
                        print_r($model->getErrors());
                    }
                }

                if ($count) {
                    ConsoleHelper::debug('Сохранено '.$count.' задач для для проекта #'.$item['id'], true);
                }
            }
        }

        return $allCount;
    }
}