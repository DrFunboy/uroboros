<?php

$cfg = getClubConfig('vpbx', true);
$mcnAliasId = getClubStatusAlias('idExtid', 'idUser_mcn')["id"];
$apiUrl = 'https://api.mcn.ru/v2/rest/account/';
$json = array(
    'clubStatus' => getClubStatus('idTalk'),
);
$idTalkStatus = array();
foreach ($json['clubStatus'] as $status) {
    $idTalkStatus[ $status['alias'] ] = $status;
}

if (!empty($_GET["call_id"])) {
    // запись звонка
    $url = $apiUrl.$cfg["account"].'/vpbx/'.$cfg["vats"].'/call_log/record?call_id='.$_GET["call_id"].'&user_hash='.$cfg["token"];
    $file = file_get_contents($url);
    die( $file );
} elseif ($_POST["phone"]){
    // инициализация звонка
    $operator = getClubExtId(array(
        'parent' => $userID,
    ), 'idUser_mcn');
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $apiUrl.$cfg['account']."/vpbx/{$cfg['vats']}/outbound_call?user_hash=" . $cfg['token'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_TIMEOUT => 0,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('from' => $operator["extoken"], 'to' => $_POST["phone"])
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    die( $response );
} elseif ($rq[2]=='missed') {
    // пропущенные звонки
    $w = $modx->newQuery('idTalk', array(
        'idStatus.alias' => 'callinBegin', // 'calloutBegin'
    ));
    $w->innerJoin('idStatus');
    $json['total'] = $modx->getCount('idTalk', $w);
} elseif ($rq[2]=='operators') {
    //список операторов
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $apiUrl.$cfg["account"].'/sip_statuses?did='.$cfg["number"].'&user_hash='.$cfg["token"],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_TIMEOUT => 0,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    $response = json_decode($response, true);

    curl_close($curl);
    if ($response["code"] == 200) {
        $json['operators1'] = $response['items'];
        foreach($response['items'] as $item) {
            $json['operators'][ $item['name'] ] = $json['operators'][ $item['name'] ] || $item['registered'];
        }

        $w = $modx->newQuery('idExtid', array(
            'exType.alias' => 'idUser_mcn',
        ));
        $w->innerJoin('idStatus', 'exType');
        $w->innerJoin('modUserProfile', 'Profile', 'Profile.internalKey = idExtid.parent');
        $w->select(array(
            'idExtid.*',
            'Profile.fullname AS fullname',
        ));
        foreach ($modx->getCollection('idExtid', $w) as $row) {
            $r = $row->toArray();
            $ext = $r['extended'];
            $r['online'] = $json['operators'][ $ext['sip'] ];
            $json['rows'][] = $r;
        };
    }
} else {
    //коллбэки
    clubLog('mcnTelecom', $_POST);
    $talkAliasId = getClubStatusAlias('idExtid', 'idTalk')["id"];
    
    $call = json_decode(file_get_contents('php://input'), true);
    if ( empty($call["call_id"]) ) die;
    
    $mcnStatus = array(
        "onBegin"               => "callinBegin",
        "onInCallingAnswered"   => "callinAnswered",
        "onInAbonEnd"           => "callinEnd",
        "onInCallingEnd"        => "callinEnd",
        "onOutCallingStart"     => "calloutBegin",
        "onOutCallingAnswered"  => "calloutAnswered",
        "onOutAbonEnd"          => "calloutEnd",
        "onOutCallingEnd"       => "calloutEnd",
    );
    
    $talk = $modx->getObject('idTalk', array(
        'extid' => $call['call_id'],
    ));
    
    $status = $idTalkStatus[ $mcnStatus[ $call['event_type'] ] ];
    if ( empty($status) ) die;
    
    // Пользователи телефонии
    $telUser = getClubExtId(array(
        'extoken' => $call["abon"],
    ), 'idUser_mcn', true);
    $telUserID = empty($telUser)? null : $telUser->get('parent');
    
    /*$ops = $modx->getCollection('idExtid', array(
        'extype' => $mcnAliasId
    ));
    $opList = array();
    foreach($ops as $k => $v){
        $opList[explode(':', $v->get('extoken'))[0] ] = $v->get('parent');
    }*/
    
    if (empty($talk)) {
        $newTalk = $modx->newObject('idTalk', array(
           'status' => $status["id"],
           'local' => $call["did_mcn"],
           'foreign' => $call["did"],
           'iduser' => $telUserID,
           'extid' => $call['call_id'],
        ));
        $newTalk->save();
        /*$rowid = $newTalk->get('id');
        $extId = setClubExtId(array(
            'parent' => $rowid,
            'extoken' => $call["call_id"],
            'extended' => $call,
            'extid' => $status["id"]
        ), 'idTalk');*/
    } else {
        $talk->set('status', $status["id"]);
        $talk->set('iduser', $telUserID);
        
        if ( !empty($call['billsec']) ) $talk->set('duration', $call['billsec']);
        $talk->save();
        
        /*$extid = $modx->getObject('idExtid', array(
            'parent' => $talk->get("id"),
            'extoken' => $call["call_id"],
            'extype' => $talkAliasId
        ));
        $extid->fromArray(array(
           'extended' => $call,
           'extid' => $status["id"],
        ));
        
        $extid->save();*/
        
        if ( $status["alias"] == "callinEnd" || $status["alias"] == "calloutEnd") {
            $missed = $modx->getCollection('idTalk', array(
                'status' => $idTalkStatus['callinBegin']['id'],
                'foreign' => $call["did"],
            ));
            
            foreach ($missed as $k => $v) {
                $v->set('status', $idTalkStatus['recall']['id']);
                $v->save();
            }
        }
    }
}
