<?php

namespace App\Handler;

use App\Entity\Task;
use App\Service\GlobalConfigManager;

class TaskTypeHandler extends GlobalConfigManager{

    const ENTITY_NAME = "TaskType";
    const ID_PARAM    = "taskTypeId";

    public function get($params){
        $taskTypeId = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

        return $this->ifExistsGetTaskTypeById($taskTypeId);
    }

    private function ifExistsGetTaskTypeById($taskTypeId){
        $taskType = $this->repository(self::ENTITY_NAME)->find($taskTypeId);

        null === $taskType ?? throw new \Exception("Task with id $taskTypeId not found");
        return $taskType;
    }
}