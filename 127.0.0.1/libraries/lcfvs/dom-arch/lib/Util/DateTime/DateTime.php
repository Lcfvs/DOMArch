<?php
namespace DOMArch\Util;

class DateTime extends \DateTime
{
    const
        NOW = 'now',

        NEXT_QUART_HOUR = '+ 15 min',
        NEXT_HALF_HOUR = '+ 30 min',
        NEXT_HOUR = 'next hour',
        NEXT_DAY = 'next day',
        NEXT_WEEK = 'next week',
        NEXT_MONTH = 'next month',
        NEXT_YEAR = 'next year',
        NEXT_MONDAY = 'next monday',
        NEXT_TUESDAY = 'next tuesday',
        NEXT_WEDNESDAY = 'next wednesday',
        NEXT_THURSDAY = 'next thursday',
        NEXT_FRIDAY = 'next friday',
        NEXT_SATURDAY = 'next saturday',
        NEXT_SUNDAY = 'next sunday',

        PREVIOUS_QUART_HOUR = '- 15 min',
        PREVIOUS_HALF_HOUR = '- 30 min',
        PREVIOUS_HOUR = 'previous hour',
        PREVIOUS_DAY = 'previous day',
        PREVIOUS_WEEK = 'previous week',
        PREVIOUS_MONTH = 'previous month',
        PREVIOUS_YEAR = 'previous year',
        PREVIOUS_MONDAY = 'previous monday',
        PREVIOUS_TUESDAY = 'previous tuesday',
        PREVIOUS_WEDNESDAY = 'previous wednesday',
        PREVIOUS_THURSDAY = 'previous thursday',
        PREVIOUS_FRIDAY = 'previous friday',
        PREVIOUS_SATURDAY = 'previous saturday',
        PREVIOUS_SUNDAY = 'previous sunday';

    public static function create(
        $time = DateTime::NOW
    ) {
        if (is_int($time)) {
            return (new \DateTime())->setTimestamp($time);
        }

        return new static($time);
    }

    public function clone() {
        return clone $this;
    }
}