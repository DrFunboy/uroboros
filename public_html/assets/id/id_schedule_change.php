<?php
require_once('id_init.php');
$json = array();

$value  = $modx->getOption('value', $_REQUEST, 0);
if (empty($value)) die('');

$field  = $modx->getOption('field', $_REQUEST, 'trainer');
$ids  = $modx->getOption('ids', $_REQUEST, '');
$mode = $modx->getOption('mode', $_REQUEST, 'repeat'); // this
$weekstart  = $modx->getOption('weekstart', $_REQUEST, 'first day of this week');

$schedules = $modx->getIterator('idSchedule', array(
    'id:IN' => explode(',', $ids),
));

foreach($schedules as $schedule) {
    if (($mode!='repeat') && !empty($schedule->get('repeat'))) {
        $addata = $schedule->toArray();
        $addata['parent'] = $addata['id'];
        unset($addata['id']);
        $addata['repeat'] = 0;
        $addata['author'] = $userID;

        $datestart = new DateTime($addata['datestart']);
        $dateend = new DateTime($addata['dateend']);
        $week_day = $datestart->format('N') - 1;
        $start = new DateTime($weekstart);
        $start->modify("+{$week_day} days");
        $addata['datestart'] = $start->format('Y-m-d ').$datestart->format('H:i:00');
        $addata['dateend'] = $start->format('Y-m-d ').$dateend->format('H:i:00');
        $json['data'][] = $addata;
        $schedule = $modx->newObject('idSchedule', $addata);
    }
    $schedule->set($field, $value);
    $schedule->save();
}

echo json_encode($json);