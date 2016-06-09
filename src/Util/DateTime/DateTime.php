<?php
namespace DOMArch\Util;

class DateTime extends \DateTime
{
    const NOW = 'now';

    const NEXT_HOUR = 'next hour';
    const NEXT_DAY = 'next day';
    const NEXT_WEEK = 'next week';
    const NEXT_MONTH = 'next month';
    const NEXT_YEAR = 'next year';
    const NEXT_MONDAY = 'next monday';
    const NEXT_TUESDAY = 'next tuesday';
    const NEXT_WEDNESDAY = 'next wednesday';
    const NEXT_THURSDAY = 'next thursday';
    const NEXT_FRIDAY = 'next friday';
    const NEXT_SATURDAY = 'next saturday';
    const NEXT_SUNDAY = 'next sunday';

    const PREVIOUS_HOUR = 'previous hour';
    const PREVIOUS_DAY = 'previous day';
    const PREVIOUS_WEEK = 'previous week';
    const PREVIOUS_MONTH = 'previous month';
    const PREVIOUS_YEAR = 'previous year';
    const PREVIOUS_MONDAY = 'previous monday';
    const PREVIOUS_TUESDAY = 'previous tuesday';
    const PREVIOUS_WEDNESDAY = 'previous wednesday';
    const PREVIOUS_THURSDAY = 'previous thursday';
    const PREVIOUS_FRIDAY = 'previous friday';
    const PREVIOUS_SATURDAY = 'previous saturday';
    const PREVIOUS_SUNDAY = 'previous sunday';

    public static function create($time = DateTime::NOW) {
        if (is_int($time)) {
            return (new \DateTime())->setTimestamp($time);
        }

        return new static($time);
    }

    public function clone() {
        return clone $this;
    }
}