<?php

namespace App\Handler;

use App\Entity\Summary;
use App\Service\GlobalConfigManager;

class SummaryHandler extends GlobalConfigManager{

    const ENTITY_NAME = "Summary";
    const ID_PARAM    = "summaryId";
    const DATE_PARAM  = "creationDate";

    public function set($params, bool $edit = false):Summary{
        $creationDate      = isset($params[self::DATE_PARAM])    ? $this->convertTimestampToDateTime($params[self::DATE_PARAM]) : null;
        $hoursWorked       = isset($params["hoursWorked"])       ? $params["hoursWorked"]       : 0;
        $totalWorkingHours = isset($params["totalWorkingHours"]) ? $params["totalWorkingHours"] : 0;
        $userId            = isset($params["userId"])            ? $params["userId"]            : 0;

        $summary = !$edit ? new Summary() : $this->ifExistsGetSummaryByDateAndUser($creationDate, $userId);
        $summary->setHoursWorked($hoursWorked);
        $summary->setTotalWorkingHours($totalWorkingHours);
        $this->validateEntities($userId);
        $summary->setUser($this->repository(UserHandler::ENTITY_NAME)->find($userId));
        if($this->validateDateCreation($creationDate))
            $summary->setCreationDate();
        return $summary;
    }

    public function beforeSave(Summary $summary):Summary{
        $this->repository(self::ENTITY_NAME)->save($summary, true);
        return $summary;
    }

    public function remove($params){
        $date   = isset($params[self::DATE_PARAM]) ? $this->convertTimestampToDateTime($params[self::DATE_PARAM]) : null;
        $userId = isset($params["userId"])         ? $params["userId"] : 0;

        $this->repository(self::ENTITY_NAME)->remove($this->ifExistsGetSummaryByDateAndUser($date, $userId), true);
        return "Deleted summary";
    }

    public function get($params){
        $date   = isset($params[self::DATE_PARAM]) ? $this->convertTimestampToDateTime($params[self::DATE_PARAM]) : null;
        $userId = isset($params["userId"])         ? $params["userId"] : 0;

        return $this->ifExistsGetSummaryByDateAndUser($date, $userId);
    }

    public function search($params){
        $params["firstDate"] = isset($params["firstDate"])   ? $this->convertTimestampToDateTime($params["firstDate"]) : null;
        $params["secondDate"] = isset($params["secondDate"]) ? $this->convertTimestampToDateTime($params["secondDate"]) : new \DateTime();
        isset($params["userId"]) ? $params["userId"] : $params["userId"] = 0;

        $this->validateSituationsBetweenFirstAndSecondDate($params);
        $this->clearInvalidParams($params);
        return $this->repository(self::ENTITY_NAME)->findByParamsWithQuery($params);
    }

    private function validateSituationsBetweenFirstAndSecondDate($params){
        if($params["firstDate"] !== null && $params["firstDate"] > $params["secondDate"])
            throw new \Exception("secondDate param shouldn't be minor to firstDate param");
    }

    private function validateDateCreation($creationDate){
        if(null !== $creationDate)
            return false;
        else
            return true;
    }

    private function clearInvalidParams(&$params){
        $firstDate  = "firstDate";
        $secondDate = "secondDate";
        $userId     = "userId";

        if(null === $params[$firstDate])
            unset($params[$firstDate]);
        if(null === $params[$secondDate])
            unset($params[$secondDate]);
        if($params[$userId] === 0)
            unset($params[$userId]);
    }

    private function ifExistsGetSummaryByDateAndUser($date, $userId){
        $summary = $this->repository(self::ENTITY_NAME)->findOneBy(array("creationDate" => $date, "user" => $userId));
        if(null === $summary)
            throw new \Exception("Summary with date {$date->format('Y-m-d H:i:s')} and user with id $userId not found");
        return $summary;
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