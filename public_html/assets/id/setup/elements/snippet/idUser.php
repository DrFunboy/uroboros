$email = $modx->getOption('email', $scriptProperties, $_POST['email']);
$fullname = $modx->getOption('fullname', $scriptProperties, $_POST['fullname']);
$name = $modx->getOption('name', $scriptProperties, $_POST['name']);
$user_group = $modx->getOption('user_group', $scriptProperties, $_POST['user_group']);
$iduser_row = $modx->getOption('iduser_row', $scriptProperties, $_POST['iduser_row']);
// Параметр iduser_row обновит в классе $user_group строку, добавит к ней iduser

$out = array(
    'email' => $email = trim(strtolower($email)),
    'password' => '',
);

if (!empty($email) && !empty($user_group)) {
    $Profile = $modx->getObject('modUserProfile', array('email' => $email));
    if (empty($Profile)) {
        $modUser = $modx->getObject('modUser', array('username' => $email));
        if (empty($modUser) ) {
            // Создаем пользователя если не найдем с таким mail
            $modUser = $modx->newObject('modUser', array('username' => $email));
            $out['password'] = $modUser->generatePassword(); // для письма
            $modUser->set('password', $out['password']);
            $modUser->save();
        } else {
            $Profile = $modx->getObject('modUserProfile', array('internalKey' => $modUser->get('id')));
        }
    } else {
        $modUser = $modx->getObject('modUser', $Profile->get('internalKey'));
    }
    
    if (empty($Profile)) {
        $ProfileData = array(
            'email' => $email,
            'fullname' => $fullname,
            'internalKey' => $modUser->get('id'),
        );
        $rowCity = $modx->getObject('idCity', $modx->getOption('club_city', $_SESSION, 0));
        if (!empty($rowCity)) {
            $ProfileData['city'] = $rowCity->get('name');
            if (!empty($modUser)) {
                $modx->runSnippet('setUserCity', array(
                    'idCity' => $rowCity,
                    'user' => $modUser,
                ));
            }
            /*$wcity = array(
                'id1' => $modUser->get('id'),
                'tbl1' => 'modUser',
                'tbl2' => 'idCity',
            );
            
            $idLink = $modx->getObject('idLink', $wcity);
            if (empty($idLink)) $idLink = $modx->newObject('idLink', $wcity);
            $idLink->set('id2', $rowCity->get('id'));
            $idLink->save();*/
        }
        $Profile = $modx->newObject('modUserProfile', $ProfileData);
        $Profile->save();
    }
    
    if (!empty($iduser_row)) $idUserRow = $modx->getObject($user_group, $iduser_row);
    if (!empty($idUserRow)) {
        $idUserRow->set('iduser', $modUser->get('id'));
        if (empty($idUserRow->get('email'))) $idUserRow->set('email', $Profile->get('email'));
        if (($user_group == 'idSportsmen') && empty($idUserRow->get('contact'))) $idUserRow->set('contact', $fullname);
        $idUserRow->save();
    }
    
    // Для SAAS систем
    $modUser->joinGroup('www_'.substr(CRM_PREFIX, 0, -1), 'Member', 110);
    /*$www = $modx->getObject('modUserGroup', array('name' => ));
    if (!empty($www)) {
        $wugm = array(
            'user_group' => $www->get('id'),
            'member' => $modUser->get('id'),
        );
        $ugm = $modx->getObject('modUserGroupMember', $wugm);
        if (empty($ugm)) {
            $wugm['rank'] = 30;
            $wugm = $modx->newObject('modUserGroupMember', $wugm);
            $wugm->save();
        }
    }*/
    
    // Добавление в группу
    $idPermission = getClubStatusAlias('idPermission', $user_group);
    $out['modUserGroupMember'] = $modUser->joinGroup($user_group, 'Member', empty($idPermission)? null : $idPermission['menuindex']);
    /*$modx->runSnippet('dbedit', array(
        'data' => array(
            'oper' => 'add',
            'table' => 'modUserGroupMember',
            'member' => $modUser->get('id'),
            'id' => $user_group,
        )    
    ));*/
    
    // Уведомления
    $tpl = ($user_group == 'idSportsmen')? 'idSportsmen' : 'idStuff';
    
    $modx->runSnippet('makeMsg', array(
        'handler' => "newUser_{$tpl}",
        'data' => array(
            'email' => $email,
            'name' => empty($name)? $fullname : $name,
            'password' => $out['password'],
        ),
    ));
} else {
    $out['error'] = 'Empty email or user_group';
}

$modx->setPlaceholder('idUser', $out);

return json_encode($out, JSON_UNESCAPED_UNICODE);