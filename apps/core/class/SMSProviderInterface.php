<?php

interface SMSProviderInterface {

    static function getRemain();

    static function isDelivered($referneceCode);
}
