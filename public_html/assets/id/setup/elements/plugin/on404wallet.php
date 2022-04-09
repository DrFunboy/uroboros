//if ($modx->event->name != 'OnPageNotFound') {return false;}
if (defined('CLUB_FORWARD1')) return false;
define('CLUB_FORWARD1', 1);

$rq = explode('/', $_REQUEST['q']);

$awallet_pwd = 'SCRM1234';

if ($rq[0]=='awallet') {
    require(MODX_ASSETS_PATH.'wallet/vendor/autoload.php');
    
    $PKdata = [
        'description' => 'Demo pass',
        'formatVersion' => 1,
        'organizationName' => 'org. name',
        'passTypeIdentifier' => 'pass.club.sportcrm.olympico', // Change this!
        'webServiceURL' => 'https://dev.sportcrm.club/awallet/',
        'authenticationToken' => 'sdsddsd2ds1212d2sd1s2d1',
        'serialNumber' => '12345678',
        'teamIdentifier' => 'MCM62MF945', // Change this!
        'storeCard' => [
            "primaryFields" => [
                [
                    "key" => "depart",
                    "label" => "SAN FRANCISCO",
                    "value" => "Фамилия3 Имя3 Отчество4",
                    "changeMessage" => "Теперь ты %@."
                ],
            ],
        	"headerFields" =>[
        		[
        			"key" => "header",
        			"value" => '$300',
        			"label" => "Balance",
        			"textAlignment" => "PKTextAlignmentCenter"
        		]
        	],
        	"secondaryFields" => [
          		[
           			"key" => "meal",
            		"label" => "Баланс",
            		"value" => '$459',
            		"textAlignment" => "PKTextAlignmentCenter",
            		"changeMessage" => "Изменение баланса %@."
          		]
        	]
        ],
        'barcode' => [
            'format' => 'PKBarcodeFormatQR',
            'message' => 'Flight-GateF12-ID6643679AH7BXX-XX',
            'messageEncoding' => 'iso-8859-1',
        ],
        'backgroundColor' => 'rgb(95,100,53)',
        'foregroundColor' => 'rgb(255,255,255)',
        'labelColor' => 'rgb(255,255,255)',
        'logoText' => 'Rtext',
        'relevantDate' => date('Y-m-d\TH:i:sP')
    ];
    
    
    $modx->log(modX::LOG_LEVEL_ERROR, "LogWALLET_1 ".json_encode($_REQUEST, JSON_UNESCAPED_UNICODE));
    
    if ($rq[2]=='devices' && empty($rq[6])) {
        $date = new DateTime();
        $PKUpdate = [
            "lastUpdated" => (string) $date->getTimestamp(),
            "serialNumbers" => [ "12345678" ],
        ];
        $modx->log(modX::LOG_LEVEL_ERROR, "LogWALLET_EmptySerial ".json_encode($PKUpdate, JSON_UNESCAPED_UNICODE));
        
        echo json_encode($PKUpdate, JSON_UNESCAPED_UNICODE);
    } else {
        $modx->log(modX::LOG_LEVEL_ERROR, "LogWALLET_Body ".file_get_contents('php://input'));
        
        $pass = new PKPass\PKPass(MODX_ASSETS_PATH.'wallet/cert/applewallet.p12', $awallet_pwd);
        $pass->setData($PKdata);
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/icon.png');
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/icon@2x.png');
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/logo.png');
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/logo@2x.png');
        //$pass->addFile(MODX_ASSETS_PATH.'wallet/images/background.png', 'strip.png');
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/thumbnail.png');
        $pass->addFile(MODX_ASSETS_PATH.'wallet/images/thumbnail@2x.png');
    
        // Create and output the pass
        if(!$pass->create(true)) {
            $modx->log(modX::LOG_LEVEL_ERROR, "LogWALLET_ErrorCreate ".$pass->getError());
        }
    }
    exit();
}

if ($rq[0]=='pushwallet') {
    $ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', MODX_ASSETS_PATH.'wallet/cert/applewallet.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', $awallet_pwd);
	$fp = stream_socket_client(
		'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp) {
	    $modx->log(modX::LOG_LEVEL_ERROR, "LogWALLET_ErrorPush $err $errstr");
	} else {
	    //$pushToken = '2f4bb8e437593aec8e84bbaa2d9b39ac4f4ebdee6b4d3a22b3e41deb17797918'; // Андрей
	    //$pushToken = 'fyiLfJybQN6bFcpp2MpDyE:APA91bFHaAEyQoKFu59wXgtbFG-ezpja-_R6s9Qiz6d3W3HBNF-fdWdZcPLrVNR56oRSjLpg1a1_AxhqRdjjr6sbZaBr2U_6xA7mibo1RMaPPlBwgjMsi0DYfHe93HrlI5WLksO03uLK'; // Андрей2
	    //$pushToken = '7f62983da1ccc14e5d4fbf3f82ef35be7d5e2994e81d458e313740c8cb4a1c18'; // iPhone6
	    $pushToken = '5f1f8afde7494bdc1c2efdece421528c6524e86ad04ebfb2cd01ec82a7a09608'; // iPhone12Pro
	    
	    $passIdentify = 'pass.club.sportcrm.olympico';
	    
	    $body['aps'] = array();
        // Encode the payload as JSON
	    $payload = json_encode($body);
	    // Build the binary notification
	    $msg = chr(0) . pack('n', 32) . pack('H*', $pushToken) . pack('n', strlen($payload)) . $payload . pack('n', strlen($passIdentify)) . $passIdentify;
	    // Send it to the server
	    $result = fwrite($fp, $msg, strlen($msg));
	    fclose($fp);
	    if (!$result)
	        $modx->log(modX::LOG_LEVEL_ERROR, "Message not delivered");
    	else
    	    $modx->log(modX::LOG_LEVEL_ERROR, "Message successfully delivered");
	}
}