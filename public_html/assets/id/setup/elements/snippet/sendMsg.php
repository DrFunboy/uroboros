if (!empty($row)) $rows = array( "{$row->get('id')}" => $row );
if (empty($rows)) {
    $msg_id = $modx->getOption('msg_id', $scriptProperties, 0);
    $rows = $modx->getCollection('idMsg', $msg_id);
}

$mcfg = clubConfig('mailBrand,SMTP');
if (!empty($mcfg['SMTP'])) {
    $smtp = json_decode($mcfg['SMTP'], true);
    $smtp['mail_use_smtp'] = 1;
    if ($smtp['mail_smtp_pass']=='*******') $smtp['mail_smtp_pass'] = 's3cG5FuW';
    foreach($smtp as $okey => $oval) {
        $modx->setOption($okey, $oval);
    }
}

foreach ($rows as $msg_key => $msg) {
    $type = $msg->get('type');
    $msg_body = $msg->get('info');
    $msg_to = explode(',', $msg->get('msg_to'));
    $msg_ext = $msg->get('extended'); // Для лога

    $msg->fromArray(array(
        'attempt' => $msg->get('attempt')+1,
        'datestart' => date('c'),
    ));
    $msg->save(); // Запись попытки
    
    if ($type=='email' || $type=='mail') {
        if (empty($modx->mail)) $modx->getService('mail', 'mail.modPHPMailer');
        
        $msg_body = clubTmpl($mcfg['mailBrand'], array(
            'content' => $msg_body,
        ));
            
        //$msg_body = $modx->getChunk("mailBrand", array('content' => $msg_body));
        $modx->mail->set(modMail::MAIL_BODY, $msg_body);
        $modx->mail->set(modMail::MAIL_FROM, $modx->getOption('emailsender'));
        $modx->mail->set(modMail::MAIL_FROM_NAME, $modx->getOption('site_name'));
        $modx->mail->set(modMail::MAIL_SUBJECT, $msg->get('msg_subj'));
        foreach ($msg_to as $email) {
            $email_arr = explode(':', $email);
            //reply-to,bcc
            if (sizeof($email_arr) > 1) {
                $modx->mail->address($email_arr[0], $email_arr[1]);
            } else {
                $modx->mail->address('to', $email);
            }
        }

        $modx->mail->setHTML(true);
        foreach($_FILES as $file) {
            foreach($file['error'] as $n => $error) if (empty($error)) {
                $modx->mail->attach($file['tmp_name'][$n], $file['name'][$n]);
                //$modx->mail->mailer->addAttachment($file['tmp_name'][$n], $file['name'][$n]);
            }
        }
        if (!$modx->mail->send()) {
            $msg_ext['error'] = $modx->mail->mailer->ErrorInfo;
            $modx->log(modX::LOG_LEVEL_ERROR, "Error while trying send email ({$msg_key}): {$msg_ext['error']}");
            $msg->set('extended', $msg_ext);
        } else {
            $msg->set('ready', 1);
        }
        $msg->save();
        $modx->mail->reset();
    }
    if ($msg->get('type') == 'sms') {
        $api_key = $modx->getOption('sms_api_key'); // '7AA512BF-70DE-F958-D2F9-0C6509B86965'
        if (!empty($api_key)){
            require_once MODX_ASSETS_PATH.'id/phplib/sms.ru/sms.ru.php';
            $smsru = new SMSRU($api_key); // Ваш уникальный программный ключ, который можно получить на главной странице
            
            $data = new stdClass();
            $data->to = $msg_to[0];
            $data->text = $msg_body; // Текст сообщения
            // $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
            // $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
            // $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
            //$data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
            // $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
            $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
            
            $result = array('status' => $sms->status);
            if ($result['status'] == "OK") { // Запрос выполнен успешно
                $result['id'] = $sms->sms_id;
                $result['balance'] = $sms->balance;
                $msg->set('ready', 1);
            } else {
                $result['status_code'] = $sms->status_code;
                $result['status_text'] = $sms->status_text;
            }
            $msg_ext['result'] = $result;
            $msg->set('extended', $msg_ext);
            $msg->save();
        }
    }
}