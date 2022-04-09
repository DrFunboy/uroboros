<?php

function getClubThumb($file_name, $size = 'sm', $gender = '') {
    global $modx;
    $thumbSizes = array(
        "thumb" => 'f=jpeg&q=90&w=200&h=200&zc=C&ar=x',
        "sm" => 'f=jpeg&q=80&w=400&h=400&zc=C&ar=x',
        "md" => 'f=jpeg&q=75&w=700&ar=x',
        "logo" => 'f=jpeg&q=100&wl=350&hp=270&hs=300&ar=x',
    );
    
    if (gettype($file_name)=='array') {
        $file_name = "{$file_name['filetype']}/{$file_name['key']}.{$file_name['fileext']}";
    }

    $img_file = CRM_FILES . $file_name;
    if (!empty($file_name) && file_exists($img_file)) {
        // original ??
        return $modx->runSnippet('phpthumbon', array(
            'input' => $img_file,
            'options' => $thumbSizes[$size],
        ));
    } else {
        return CRM_URL."images/no-image{$gender}.png";
    }
}



/*
$headers = $modx->request->getHeaders();
$mtime = filemtime($out_file);
if (isset($headers['If-Modified-Since']) && strtotime($headers['If-Modified-Since']) == $mtime) {
    // cache is good, send 304
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $mtime).' GMT', true, 304);
    exit();
}
//header('Last-Modified: '.gmdate('D, d M Y H:i:s', $mtime).' GMT', true, 200);
//$phpThumb->setOutputFormat();
header('Content-Type: '.mime_content_type($out_file));
header('Content-Disposition: inline; filename="'.basename($out_file).'"');

$d = new DateTime('+1 month');
header('Cache-Control: public, max-age=10800');
header('Connection: keep-alive');
//header('Content-Type: image/' . pathinfo($out_file, PATHINFO_EXTENSION));
header('Expires: '.$d->format('D, d M Y H:i:s').' GMT');
header_remove('Pragma');

//header('Location: '.$out_file, true, 301);

echo file_get_contents($out_file);
*/