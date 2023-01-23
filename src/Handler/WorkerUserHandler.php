<?php

namespace App\Handler;

use App\Entity\WorkerUser;
use App\Service\GlobalConfigManager;

class WorkerUserHandler extends GlobalConfigManager{

    const ENTITY_NAME = "WorkerUser";
    const ID_PARAM    = "workerUserId";

    public function set($params, bool $edit = false):WorkerUser{
        $workerUserId      = isset($params[self::ID_PARAM])      ? $params[self::ID_PARAM]      : 0;
        $workingMinutes    = isset($params["workingMinutes"])    ? $params["workingMinutes"]    : 0;
        $restMinutes       = isset($params["restMinutes"])       ? $params["restMinutes"]       : 0;
        $totalWorkingHours = isset($params["totalWorkingHours"]) ? $params["totalWorkingHours"] : 0;
        $userId            = isset($params["userId"])            ? $params["userId"]            : 0;

        $workerUser = !$edit ? new WorkerUser() : $this->ifExistsWorkerUserById($workerUserId);
        $this->validateEntities($userId);
        $workerUser->setWorkingMinutes($workingMinutes);
        $workerUser->setRestMinutes($restMinutes);
        $workerUser->setTotalWorkingHours($totalWorkingHours);
        $workerUser->setUser($this->repository(UserHandler::ENTITY_NAME)->find($userId));
        return $workerUser;
    }

    public function beforeSave(WorkerUser $task):WorkerUser{
        $this->repository(self::ENTITY_NAME)->save($task, true);

        return $task;
    }

    // public function remove($params){
    //     $taskId = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

    //     $this->repository(self::ENTITY_NAME)->remove($this->ifExistsGetTaskById($taskId), true);
    //     return "Deleted task";
    // }

    private function ifExistsWorkerUserById($workerUserId){
        $workerUser = $this->repository(self::ENTITY_NAME)->find($workerUserId);
        if(null === $workerUser)
            throw new \Exception("WorkerUser with id $workerUserId not found");
        return $workerUser;
    }

    private function validateEntities($userId){
        $this->validateUserEntity($userId);
    }

    private function validateUserEntity($userId){
        $user = $this->repository(UserHandler::ENTITY_NAME)->find($userId);
        if(null === $user)
            throw new \Exception("User with id $userId not found");
    }

}