<?php

$tools_start_folder = CRMTOOLS_PATH.'start/';
if (!file_exists($tools_start_folder)) mkdir($tools_start_folder, 0755, true);
$wprefix = file_get_contents('https://w.sportcrm.club/hook/wprefix/'.strtolower($_SERVER['HTTP_HOST']));
file_put_contents($tools_start_folder.'wprefix.php', $wprefix);
include($tools_start_folder.'wprefix.php');

$prefixRow = $www[ $_SERVER['HTTP_HOST'] ];
if (!empty($prefixRow)) {
    $w_prefixGroup = array(
        'name' => 'www_'.$prefixRow['prefix'],
    );
    if (($prefixGroup = $modx->getObject('modUserGroup', $w_prefixGroup)) == null) {
        $prefixGroup = $modx->newObject('modUserGroup', $w_prefixGroup);
        $prefixGroup->save();
    }
    $managerUser = $modx->getObject('modUser', array('username' => $prefixRow['manager']));
    if (!empty($managerUser)) {
        $managerUser->joinGroup($prefixGroup->get('id'), 'Member', 110);
    }
}

$clubid_query = $modx->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.`TABLES`
    WHERE TABLE_NAME LIKE '". CRM_PREFIX ."%' AND ENGINE = 'MyISAM'");
foreach ($clubid_query->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $modx->exec("ALTER TABLE `{$row['TABLE_NAME']}` ENGINE=InnoDB");
    echo "Конвертирую {$row['TABLE_NAME']}<br>";
}

include_once(__DIR__.'/club_setup_db_fields.php');

/*$result = $modx->query("SHOW TRIGGERS");
$row = $result->fetchAll(PDO::FETCH_ASSOC);
print_r($row);*/

foreach (glob("trigger/*", GLOB_BRACE) as $tpl_file) {
    $pi = pathinfo($tpl_file);
    $filename = $pi['filename'];
    $sql_name = str_replace("@@@", CRM_PREFIX, $filename);
    $sql_text = str_replace("@@@", CRM_PREFIX, file_get_contents($tpl_file));
    if ($pi['extension'] == 'txt') {
        $modx->exec("DROP PROCEDURE IF EXISTS `{$sql_name}`");
        if (!empty($sql_text)) {
            $modx->exec("CREATE PROCEDURE `{$sql_name}` ".$sql_text);
        }
    } else {
        $modx->exec("DROP TRIGGER IF EXISTS `{$sql_name}`");
        if (!empty($sql_text)) {
            $modx->exec("CREATE TRIGGER `{$sql_name}` ".$sql_text);
        }
    }
}

$idConfig = $modx->getTableName('idConfig');
if (!empty($idConfig)) { // БД Инициализирована
    $idSportsmen = $modx->getTableName('idSportsmen');
    $idChanges = $modx->getTableName('idChanges');
    
    /*$modx->exec("DROP TRIGGER IF EXISTS `".CRM_PREFIX."sportsmen_ai`");
    $modx->exec("CREATE TRIGGER `".CRM_PREFIX."sportsmen_ai`
    AFTER INSERT ON $idSportsmen FOR EACH ROW
    INSERT INTO $idChanges SET sportsmen = NEW.id, newvalue = 'new', author = NEW.author;");*/
    
    //$modx->exec("ALTER TABLE {$idConfig} CHANGE `value` `val` text");

    //$idEvent = $modx->getTableName('idEvent');
    //$modx->exec("ALTER TABLE {$idEvent} MODIFY `status` varchar(70) NOT NULL DEFAULT '' ");
    
    //$modUserGroupMember = $modx->getTableName('modUserGroupMember');
    //$modx->exec("CREATE INDEX member ON {$modUserGroupMember}(member)");
    
    //$sql = "DROP TRIGGER IF EXISTS `%prefix%sportsmen_ai`";
    //$modx->exec(str_replace("%prefix%", CRM_PREFIX, $sql));
    
    
    $modx->updateCollection('idChanges', array('newvalue' => 'new'), array(
        'newvalue' => 'Новый',
        'chfield' => 'status',
    ));
    
    
    $modx->removeCollection('idSportsmenSquad', array('sportsmen' => 0));

    $modx->updateCollection('idSportsmenSquad', array(
        'published' => null,
        'dateend' => '2020-08-31',
        'editedby' => 0,
    ), array(
        "sportsmen IN (SELECT id FROM {$idSportsmen} where status = 'Архив')",
        'dateend' => null,
    ));
    
    $modx->updateCollection('idSportsmen', array(
        'discount' => '',
    ), array(
        'discount' => '*',
    ));
    
    $modx->updateCollection('idSportsmen', array(
        'razr' => '',
    ), array(
        'razr' => '*',
    ));
    
    /*
    
    $modx->exec("ALTER TABLE {$idSportsmen} MODIFY `razr` varchar(100) NOT NULL DEFAULT '' ");
    $modx->exec("ALTER TABLE {$idSportsmen} MODIFY `status` varchar(25) NOT NULL DEFAULT 'Действует' ");
    
    $idStatus = $modx->getTableName('idStatus');
    
    $idInvoice = $modx->getTableName('idInvoice');
    $stmt = $modx->prepare("DROP TRIGGER IF EXISTS `".CRM_PREFIX."inv_bu`");
    $stmt->execute();
    $modx->updateCollection('idInvoice', array('status' => ''), array('status' => 'Не определен'));
   
    $manager->removeIndex('idLesson', 'schedule');
    $manager->removeIndex('idTascom', 'datestart');
    $manager->removeIndex('idInvoice', 'period');
    $manager->removeIndex('idInvoice', 'residue');
    $manager->removeIndex('idSchedule', 'planfact');
    
    $manager->removeIndex('idEventMember', 'uq_event_member');
    $manager->removeIndex('idSportsmenSquad', 'squad');
    
    $manager->removeIndex('idEventMember', 'idevent');
    */
    
    $manager->removeIndex('idSportsmenSquad', 'uq_sp_sq');
    $manager->removeIndex('idSquad', 'squad_name');
    $manager->removeIndex('idSquad', 'squad_club');
    $manager->removeIndex('idSportsmen', 'email');
    $manager->removeIndex('idStatus', 'uq_status');
    //$manager->removeIndex('idLink', 'link1');
    
    //$manager->removeField('idStatus', 'isauto');
    
    
    // FIX NEW Field
    $sql = "INSERT IGNORE INTO $idChanges
     (`sportsmen`, `chfield`, `newvalue`, `created`, `author`)
    SELECT sp.id, 'status', 'new', sp.created, sp.author
    FROM $idSportsmen sp
    LEFT JOIN $idChanges ch on (ch.sportsmen=sp.id and ch.chfield='status' and ch.newvalue='new')
    WHERE
    ch.id is null";
    echo $modx->exec($sql);
    echo "<br>\n{$sql}<br>";

    
    foreach($data["idStatus"] as $key => $status) {
        if (in_array($status['tbl'], array('idModule','idConfig')) && !in_array($status['cls'], $club_modules)) {
            continue;
        }
        $status['club_id'] = $status['id'];
        unset($status['id'], $status['published']);
    
        $st = $modx->getObject('idStatus', array(
            'club_id' => $status['club_id'],
            array(
                'OR:tbl:=' => $status['tbl'],
                'alias' => $status['alias'],
            ),
        ));
        if (empty($st)) $st = $modx->newObject('idStatus', $status);
        $st->fromArray($status);
        $st->save();
        if ($status['tbl']=='idPayMethod') {
            $wPayMethod = array(
                'parent' => 0,
                'extid' => $st->get('id'),
            );
            if (empty(getClubExtId($wPayMethod, 'idCity_Pay'))) setClubExtId($wPayMethod, 'idCity_Pay');
        }
    }
    
    /*
    $stmt = $modx->prepare('select discount from '.CRM_PREFIX.'sportsmen group by discount');
    $stmt->execute();
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    $stmt = $modx->prepare('select categ from '.CRM_PREFIX.'trainer group by categ');
    $stmt->execute();
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    $stmt = $modx->prepare('select referee from '.CRM_PREFIX.'trainer group by referee');
    $stmt->execute();
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    */
    
    $cfg_def = array();
    foreach (glob("cfg/*", GLOB_BRACE) as $cfg_file) {
        $pi = pathinfo($cfg_file);
        $cfg_def[ $pi['filename'] ] = file_get_contents($cfg_file);
    }
    if (isset($_REQUEST['key'])) $cfg_def['club_key'] = $_REQUEST['key'];
    
    
    /*if (!empty($modx->getOption('mail_use_smtp'))) {
        $smtp = json_decode($cfg_def['SMTP'], true);
        $smtp['emailsender'] = $modx->getOption('emailsender');
        $smtp['mail_smtp_hosts'] = $modx->getOption('mail_smtp_hosts');
        $smtp['mail_smtp_port'] = $modx->getOption('mail_smtp_port');
        $smtp['mail_smtp_prefix'] = $modx->getOption('mail_smtp_prefix');
        $smtp['mail_smtp_user'] = $modx->getOption('mail_smtp_user');
        $smtp['mail_smtp_pass'] = $modx->getOption('mail_smtp_pass');
        $cfg_def['SMTP'] = json_encode($smtp);
    }*/
    
    foreach ($modx->getIterator('idConfig', array(
            'name:IN' => array_keys($cfg_def),
        )) as $cfg_row) {
        $cfg = $cfg_row->get('name');
        if ($cfg=='club_logo') $cfg_row->remove(); else // Закомментировать эту строку
        unset($cfg_def[$cfg]);
        /*if ($cfg == 'club_residue') {
            echo('<br>club_residue: '. $cfg_row->get('val'));
            $cfg_def['schedule_a'] = $cfg_row->get('val');
            $cfg_row->remove();
            
            $idLesson = $modx->getTableName('idLesson');
            $idInvoiceLesson = $modx->getTableName('idInvoiceLesson');
            $modx->exec("UPDATE {$idLesson} l JOIN {$idInvoiceLesson} il ON il.idlesson = l.id SET l.idinvoice = il.idinvoice");
            
            $idInvoice = $modx->getTableName('idInvoice');
            $idInvoiceType = $modx->getTableName('idInvoiceType');
            $modx->exec("UPDATE {$idInvoice} inv JOIN {$idInvoiceType} it ON (it.id = inv.typeinvoice) SET inv.lesson_amount = it.amount");
        }*/
    }
    foreach ($cfg_def as $cfg => $val) {
        $cfg_row = $modx->newObject('idConfig', array(
            'name' => $cfg,
            'val' => $val,
        ));
        $cfg_row->save();
        if ($cfg=='club_logo') {
            $logoFile = $modx->getObject('idFiles', array('uid' => 'logoClub'));
            if ($logoFile) {
                include_once(CRM_PATH.'club_thumb.php');
                $cfg_row->set('val', getClubThumb($logoFile->toArray(), 'logo'));
                $cfg_row->save();
            }
        }
    }
    
    
    foreach (glob("tmpl/*", GLOB_BRACE) as $tpl_file) {
        $pi = pathinfo($tpl_file);
        $filename = $pi['filename'];
        $w = array('handler' => $filename);
        $tmpl = $modx->getObject('idTmpl', $w);
        if (empty($tmpl)) {
            $w['type'] = '';
            $w['name'] = $filename;
            $tmpl = $modx->newObject('idTmpl', $w);
        }
        if ($tmpl->get('type')=='') {
            $tpl_content = preg_split('/\r\n|\r|\n/', file_get_contents($tpl_file));
            $tpl_subj = array_shift($tpl_content);
            $tmpl->set('subj', $tpl_subj);
            $tmpl->set('content', implode(PHP_EOL, $tpl_content));
            $tmpl->save();
        }
    }
    
    
    /* Defaults */
    
    if ($modx->getCount('idCity') == 0) {
        $modx->newObject('idCity', array(
            'name' => 'City1',
            'alias' => 'city1',
        ))->save();
    }
    
    if ($modx->getCount('idClub') == 0) {
        $city = $modx->getObject('idCity', array('id:!=' => null));
        $idClub = $modx->newObject('idClub', array(
            'name' => 'Club1',
            'city' => $city->get('id'),
        ));
        $idClub->save();
        $idSquad = $modx->newObject('idSquad', array(
            'name' => 'Group1',
            'club' => $idClub->get('id'),
        ));
        $idSquad->save();
    }
    
    if ($modx->getCount('idSport') == 0) {
        $modx->newObject('idSport', array(
            'name' => 'Sport1',
            'shortname' => 'SP',
            'color' => '#E8FFD1',
        ))->save();
    }
    
    if ($modx->getCount('idLevel') == 0) {
        $modx->newObject('idLevel', array(
            'name' => 'Beginner',
        ))->save();
    }
    
    if ($modx->getCount('idInvoiceType') == 0) {
        $pass = $modx->newObject('idInvoiceType', array(
            'name' => 'Group Pass',
            'period' => 'last day of this month'
        ));
        $pass->save();
        $modx->newObject('idSInvType', array(
            'stype' => 'a',
            'typeinvoice' => $pass->get('id'),
        ))->save();
    }
    
    echo "SquadFix";
    $qarcSquad = $modx->newQuery('idSportsmen', array(
        'status' => 'Архив',
        'squad' => 0,
    ));
    $qarcSquad->innerJoin('idSportsmenSquad');
    $qarcSquad->groupby('idSportsmen.id');
    $qarcSquad->select(array(
        'idSportsmen.id',
        'idSportsmen.squad',
        'MAX(idSportsmenSquad.dateend) as dateend',
    ));
    
    foreach ($modx->getCollection('idSportsmen', $qarcSquad) as $row) {
        //print_r($row->toArray());
        $qssq = $modx->newQuery('idSportsmenSquad', array(
            'sportsmen' => $row->get('id'),
            'dateend' => $row->get('dateend'),
            //"idSquad.name NOT LIKE '%Online%'",
            //"idSquad.name NOT LIKE '%Онлайн%'",
            //"idSquad.name NOT LIKE '%Вратари%'",
            //"idSquad.name NOT LIKE '%Улица%'",
            //"idSquad.name NOT LIKE '%параллель%'",
        ));
        $qssq->innerJoin('idSquad');
        $qssq->select(array(
            'idSportsmenSquad.sportsmen as id',
            'idSportsmenSquad.dateend',
            'GROUP_CONCAT(DISTINCT idSportsmenSquad.squad ORDER BY idSportsmenSquad.squad) as sq',
            'COUNT(*) as cnt',
        ));
        $qssq->groupby('idSportsmenSquad.sportsmen');
        //$qssq->prepare();
        //echo $qssq->toSQL();
        foreach ($modx->getIterator('idSportsmenSquad', $qssq) as $rowssq) {
            //print_r($rowssq->get('cnt'));
            if ($rowssq->get('cnt') > 1) {
                echo "{$rowssq->get('id')} - {$rowssq->get('cnt')}<br>";
                //print_r($rowssq->toArray());
            } else {
                $sp = $modx->getObject('idSportsmen', $row->get('id'));
                //echo "-{$rowssq->get('sq')}-<br>";
                $sp->set('squad', $rowssq->get('sq'));
                $sp->save();
                //print_r($rowssq->toArray());
            }
        }
    }
    
    // ==== Смена города
    $idExtid = getClubStatusAlias('idExtid', 'idUser_city');

    $w = $modx->newQuery('idLink', array(
        'tbl1' => 'modUser',
        'tbl2' => 'idCity',
    ));
    $w->leftJoin('idExtid', 'idExtid', "idExtid.parent=idLink.id1 AND idExtid.extype=".$idExtid['id']);
    $w->select(array('idLink.*, idExtid.id as extid'));
    $w->having('extid IS NULL');
    foreach($modx->getCollection('idLink', $w) as $row) {
        $next = $modx->newObject('idExtid', array(
            'parent' => $row->get('id1'),
            'extid' => $row->get('id2'),
            'extype' => $idExtid['id'],
        ));
        $next->save();
        print_r($row->toArray().'<br>');
    }
} // end БД Загружена
