if (empty($idFile)) {
    $file = $modx->getOption('file', $scriptProperties, '');
} else {
    $file = MODX_BASE_PATH."files/{$idFile->get('filetype')}/{$idFile->get('key')}.{$idFile->get('fileext')}";
}
$out = array();
if (!empty($file)) {
    $size = $modx->getOption('size', $scriptProperties, 'thumb,md');
    $sizes = array(
        "thumb" => 'f=jpeg&q=85&w=200&h=200&zc=C&ar=x',
        "sm" => 'f=jpeg&q=80&w=400&h=400&zc=C&ar=x',
        "md" => 'f=jpeg&q=75&w=700&ar=x',
        "logo" => 'f=jpeg&q=100&w=270&ar=x',
    );
    //$file = MODX_BASE_PATH.$file;
    if (file_exists($file)) {
        foreach (explode(',', $size) as $skey) {
            $out[$skey] = $modx->runSnippet('phpthumbon', array(
                'input' => $file,
                'options' => $sizes[$skey],
            ));
        }
    }
}
$modx->setPlaceholder('club_thumb', $out);
return (sizeof($out)==1)? $out[$size] : '';