<?php

namespace App\Handler;

use App\Entity\Task;
use App\Service\GlobalConfigManager;

class TaskHandler extends GlobalConfigManager{

    const ENTITY_NAME = "Task";
    const ID_PARAM    = "taskId";

    public function set($params, bool $edit = false):Task{
        $taskId     = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM]  : 0;
        $name       = isset($params["name"])         ? ucfirst($params["name"]) : null;
        $userId     = isset($params["userId"])       ? $params["userId"]        : 0;
        $taskTypeId = isset($params["taskTypeId"])   ? $params["taskTypeId"]    : 0;

        $task = !$edit ? new Task() : $this->ifExistsGetTaskById($taskId);
        $task->setName($name);
        $this->validateEntities($userId, $taskTypeId);
        $task->setUser($this->repository(UserHandler::ENTITY_NAME)->find($userId));
        $task->setTaskType($this->repository(TaskTypeHandler::ENTITY_NAME)->find($taskTypeId));
        $task->setCreationDate();
        return $task;
    }

    public function beforeSave(Task $task):Task{
        $this->validateTaskNameInRepository($task);

        $this->repository(self::ENTITY_NAME)->save($task, true);
        return $task;   
    }

    public function remove($params){
        $taskId = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

        $this->repository(self::ENTITY_NAME)->remove($this->ifExistsGetTaskById($taskId), true);
        return "Deleted task";
    }

    public function get($params){
        $taskId = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

        return $this->ifExistsGetTaskById($taskId);
    }

    public function search($params){
        isset($params["name"])       ? $params["name"]       : $params["name"]       = null;
        isset($params["taskTypeId"]) ? $params["taskTypeId"] : $params["taskTypeId"] = 0;

        $this->clearInvalidParams($params);
        return $this->repository(self::ENTITY_NAME)->findByParamsWithQuery($params);
    }

    private function clearInvalidParams(&$params){
        $name       = "name";
        $taskTypeId = "taskTypeId";

        if(null === $params[$name] || $params[$name] === "" || $params[$name] === " ")
            unset($params[$name]);
        if($params[$taskTypeId] == 0)
            unset($params[$taskTypeId]);
    }

    private function ifExistsGetTaskById($taskId){
        $task = $this->repository(self::ENTITY_NAME)->find($taskId);

        if(null === $task){
            throw new \Exception("Task with id $taskId not found");
        }
        return $task;
    }

    private function validateEntities($userId, $taskTypeId){
        $this->validateUserEntity($userId);
        $this->validateTaskTypeEntity($taskTypeId);
    }

    private function validateUserEntity($userId){
        $userRepository     = $this->repository(UserHandler::ENTITY_NAME);

        if(null === $userRepository->find($userId)){
            throw new \Exception("User with id $userId not found");
        }
    }

    private function validateTaskTypeEntity($taskTypeId){
        $taskTypeRepository = $this->repository(TaskTypeHandler::ENTITY_NAME);

        if(null === $taskTypeRepository->find($taskTypeId)){
            throw new \Exception("TaskType with id $taskTypeId not found");
        }
    }

    private function validateTaskNameInRepository(Task $task){
        $repository   = $this->repository(self::ENTITY_NAME);
        $existingTask = $repository->findBy(array("name" => $task->getName()));

        if(!empty($existingTask) && $existingTask[0]->getId() != $task->getId()){
            throw new \Exception("{$task->getName()} task already exists");
        }
    }
}