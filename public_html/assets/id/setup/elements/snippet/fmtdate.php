$out = "";
if (!empty($input)){
    $d = new DateTime($input);
    $out = $d->format("d.m.Y");
}

return $out;