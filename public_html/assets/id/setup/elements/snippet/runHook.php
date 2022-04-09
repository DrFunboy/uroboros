$runHook = $modx->getOption('hook', $scriptProperties, null);
if (!empty($runHook)) {
    $rq = explode('/', $runHook);
    $hooks = array(
        'hook' => "hook/{$rq[1]}.php",
        'pay' => 'hook/pay.php',
        'paycb' => 'hook/pay.php',
        'js' => 'hook/js.php',
        'data' => 'club_data.php',
        'chunk' => 'hook/chunk.php',
        'setup' => 'setup/hook.php',
    );
    $hook_file = $hooks[ $rq[0] ];
    if (!empty($hook_file)) {
        foreach (glob('{'.implode(',', [CRMTOOLS_PATH, CRM_PATH]).'}'.$hook_file, GLOB_BRACE) as $hf) {
            include_once($hf);
            if (!empty($json)) {
                return json_encode($json, JSON_UNESCAPED_UNICODE);
            }
        }
    }
}