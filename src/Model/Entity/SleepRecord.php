<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Log\Log;

/**
 * SleepRecord Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\Date $date
 * @property \Cake\I18n\Time $bedtime
 * @property \Cake\I18n\Time $wakeup_time
 * @property bool $nap_afternoon
 * @property bool $nap_evening
 * @property int $mood
 * @property string $comment
 * @property bool $sport
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class SleepRecord extends Entity
{
    protected array $_accessible = [
        'user_id' => true,
        'date' => true,
        'bedtime' => true,
        'wakeup_time' => true,
        'nap_afternoon' => true,
        'nap_evening' => true,
        'mood' => true,
        'comment' => true,
        'sport' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

protected function _getSleepCycles()
{
    $bedtime = new \DateTime($this->bedtime->i18nFormat('yyyy-MM-dd HH:mm:ss'));
    $wakeupTime = new \DateTime($this->wakeup_time->i18nFormat('yyyy-MM-dd HH:mm:ss'));

    if ($wakeupTime <= $bedtime) {
        $wakeupTime->modify('+1 day');
    }

    $interval = $bedtime->diff($wakeupTime);
    $minutes = ($interval->h * 60) + $interval->i;
    $cycles = floor($minutes / 90);

    return $cycles;
}

protected function _getSleepCycleIndicator()
{
    $cycles = $this->_getSleepCycles();
    $remainder = $cycles % 90;

    return ($cycles >= 5 || $remainder <= 10 || $remainder >= 80) ? 'green' : 'red';
}

protected function _getSleepCycleTranches()
{
    $bedtime = new \DateTime($this->bedtime->i18nFormat('yyyy-MM-dd HH:mm:ss'));
    $wakeupTime = new \DateTime($this->wakeup_time->i18nFormat('yyyy-MM-dd HH:mm:ss'));

    if ($wakeupTime <= $bedtime) {
        $wakeupTime->modify('+1 day');
    }

    $tranches = [];
    $currentCycleStart = clone $bedtime;
    while ($currentCycleStart < $wakeupTime) {
        $currentCycleEnd = clone $currentCycleStart;
        $currentCycleEnd->modify('+90 minutes');
        if ($currentCycleEnd > $wakeupTime) {
            $currentCycleEnd = $wakeupTime;
        }
        $tranches[] = $currentCycleStart->format('H:i') . ' - ' . $currentCycleEnd->format('H:i');
        $currentCycleStart = $currentCycleEnd;
    }

    return $tranches;
}
}