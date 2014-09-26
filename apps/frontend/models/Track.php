<?php

use Simplemod\Core\AtaModel;

class Track extends AtaModel {
    /**
     * QUERY TO FETCH LAST MONTH VISITS
     * SELECT day(time) , count(*) FROM `track` WHERE YEAR(`time`) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
      AND MONTH(`time`) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(time)
     */

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $ip;

    /**
     *
     * @var integer
     */
    public $url;

    /**
     *
     * @var integer
     */
    public $date;

    /**
     *
     * @var string
     */
    public $agent;

    /**
     *
     * @var string
     */
    public $time;

    /**
     *
     * @var string
     */
    public $parameters;

    public function hasUser() {
        return isset($this->userid) && intval($this->userid) > 0;
    }

    /**
     * Fetch the user who visited the page
     * @return User
     */
    public function getUser() {
        return User::findFirst($this->userid);
    }

    public function getDate() {
        return date("Y-m-d H:i:s", $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->time = date("Y-m-d H:i:s", time());
        $this->date = time();
    }

    public function getLastMonthVisitChart() {

        return $this->rawQuery("SELECT  YEAR(track.time) as year , MONTH(track.time) as month , day(track.time) as day , count(track.userid) as total FROM `track` WHERE YEAR(track.time) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(track.time) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(track.time)");
    }

    public function getLastSevenDaysVistCount() {
        return $this->rawQuery("SELECT  COUNT(*) as total FROM `track` WHERE YEAR(track.time) >= YEAR(CURRENT_DATE - INTERVAL 1 DAY)
AND MONTH(track.time) >= MONTH(CURRENT_DATE - INTERVAL 1 DAY) AND DAY(track.time) >= DAY(CURRENT_DATE - INTERVAL 1 DAY)");
    }

}