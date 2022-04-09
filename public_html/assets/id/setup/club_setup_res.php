<?php
/* ********************************
параметры:
mode включает parent - перемещает ресурс к нужному родителю
ресурсы создает всегда с published=1
********************************* */

$extension_packages = $modx->getObject('modSystemSetting', 'extension_packages');
if (!empty($extension_packages)) $extension_packages->remove();

//sportsmen - key - уникальное
//$sql = "update id_schedule set `repeat` = 1 where `parent` = 0 and `planfact`= 0";
//$modx->exec($sql);

$elems = array(
    'modChunk' => 'rowFile,chlogPlan,chlogFact,clubThumb,club_,club_scripts,dbRowSportsmenInvoice,dbRowSportsmenPay,idChCity,profileRow,mySportsmen,rowCity,payYandex,navParent4,shopGallery,leadForm,rgThumb,clubOnline,mailHelp,mailNew_idSportsmen,mailNew_idTrainer,tplPhoto,jsNewInvoice,jsSquad,tplNewCabinet',
    
    'modSnippet' => 'clubFileAdd,crmFiles,googleData,clubThumb,onlydigits,mySportsmen,idPayYandex,idPayYandexDemo,qrEnter,idGetCandidate,shop_attr,myTrainer,getClubPath,getTmplPath,fmtdate,goalNewForm,crmForm,clubMsgToAdm,idGetTrainer,idGetSportsmens,shopPay',
    
    'modPlugin' => 'afterProfileSave,shopScripts,on404',
);

foreach($elems as $el_key => $elem_names) {
    foreach($modx->getCollection($el_key, array(
        'name:IN' => explode(',', $elem_names),
    )) as $elem) {
        $elem->remove();
    }
}

$del_file = 'assets/id/edit/idTrainer_modify_after.php
assets/id/edit/idConfig_add_before.php
assets/id/edit/idLead_edit_after.php
assets/id/setup/club_setup_data.php
assets/id/report/report_idLead_source.php
assets/id/edit/modUserProfile_edit_before.php
assets/id/edit/idLead_add_before.php
assets/id/start/clubSAAS_club_load_.php
assets/id/start/clubShop_club_load_.php
assets/id/hook/amocrm_deal.php
assets/id/data/paym/club_invoice.php
assets/id/wss/style.css
assets/id/wss/style4.css
assets/id/wss/site.js
assets/id/wss/work.css
assets/id/wss/theme.css
assets/id/wss/theme.css.map
assets/id/setup/1c/ВыгрузкаЛицевогоСчета для БД центра гимнастики.epf
assets/id/id_auto_import1cpays.php
assets/id/id_import_1cpays.php
assets/id/id_data_opts.php
assets/id/report/export_leads.php
assets/id/report/export_qr.php
assets/id/report/export_qr2.php
assets/id/report/export_eventmembers.php
assets/id/edit/idGoal_edit_after.php
assets/id/edit/idGoal_add_after.php
assets/id/club_user.php
assets/id/edit/idSchedule_add_before.php
assets/id/report/report_idSportsmen_photos.php
assets/id/wss/plugins/jsrender.min.js
assets/id/edit/idTrainer_add_before.php
assets/id/id_squadtransfer.php
assets/id/hook/amocrm.php
assets/id/start/clubOnline_load.php
assets/id/id_data_export.php
assets/id/start/clubSAAS_load.php
assets/id/start/clubShop_load.php
assets/id/hook/amo_cookie.txt
assets/id/report/report_idSportsmen_addgroups.php
assets/id/handlers/invoice_recover.php
assets/id/edit/idSportsmenSquad_modify_after.php
assets/id/setup/club_reserve_db.sql
assets/id/setup/club_setup_db.sql
assets/id/id_autoinvoice.php
assets/id/hook/test.hook.php
assets/id/club_cfgfile.php
assets/id/id_changeparentdata.php
assets/id/wss/handler_admin.js
assets/id/wss/vendors.css
assets/id/wss/vendor.css
assets/id/wss/vendor.js
assets/id/wss/landing.css
assets/id/sport.insure.callback.php
assets/id/vendor.zip
assets/id/id_files.php
assets/id/setup/club_stat.php
assets/id/club_vers.php
assets/id/club_nfpays.php
assets/id/handlers/import_bank.php
assets/id/hook/sportsmen.php
assets/id/hook/ykassa.php
assets/id/hook/cfg.php
assets/id/club_editlead.php
assets/id/wss/sport.insure.js
assets/id/club_schedule_reservation.php
assets/id/id_schedule_start.php
assets/id/hook/shopdata.php';

foreach (explode(PHP_EOL, $del_file) as $dfile){
    $dfile = MODX_BASE_PATH.$dfile;
    if (file_exists($dfile)) unlink($dfile);
}

function dirDel ($dir) {
    if (!file_exists($dir)) return false;
    $d=opendir($dir);  
    while(($entry=readdir($d))!==false) { 
        if ($entry != "." && $entry != "..") { 
            if (is_dir($dir."/".$entry)) {
                dirDel($dir."/".$entry);  
            } else {
                unlink ($dir."/".$entry);  
            } 
        } 
    } 
    closedir($d);  
    rmdir($dir);  
}

$del_dir = 'assets/id/saas/
assets/id/v1/
assets/id/wss/editable/
assets/id/wss/tagsinput
assets/id/setup/schema
assets/id/elements
assets/id/tmpl';

foreach (explode(PHP_EOL, $del_dir) as $ddir){
    dirDel(MODX_BASE_PATH.$ddir);
}

/* ============================== */

$fields = array('pagetitle', 'longtitle', 'menutitle', 'alias', 'alias_visible', 'content', 'link_attributes',
'class_key', 'content_type', 'publishedon', 'isfolder', 'cacheable', 'searchable','hidemenu','richtext','club_id'); //, 'published'

$user_group = array();
foreach($data["modUserGroup"] as $key => $value){
    $w = array("name" => $value);
    if (!($el = $modx->getObject('modUserGroup', $w))) {
        $el = $modx->newObject('modUserGroup', $w);
        $el->save();
    }
    $user_group[$key] = $el->get('id');
}

$res_group = array();
foreach($data["modResourceGroup"] as $key => $value){
    $w = array("name" => $value);
    if (!($el = $modx->getObject('modResourceGroup', $w))) {
        $el = $modx->newObject('modResourceGroup', $w);
        $el->save();
    }
    $res_group[$key] = $el->get('id');
}


if ($modx->user->get('sudo')) {
    echo "sudo2";
    $ugroups = $modx->user->getUserGroupNames();
    if (!in_array('idManager', $ugroups)) $modx->user->joinGroup('idManager','Member', 5);
    if (!in_array('idAdmin', $ugroups)) $modx->user->joinGroup('idAdmin','Member', 7);
}


$wres = $modx->newQuery('modResource');
foreach (array_keys($modx->getFields('modResource')) as $_k) $wres->select($_k);
$stmt = $wres->prepare();
$stmt->execute();

$local_res = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $club_id = $row['club_id'];
    if (empty($club_id)) {
        //$prop = json_decode($row['properties'], true);
        //$club_id = $prop['club_id'];
        echo "Empty 'club_id' in {$row['id']}: {$row['pagetitle']}<br>";
    } else $local_res[$club_id] = $row['id'];
    //if (!empty($club_id)) $local_res[$club_id] = $row['id'];
}

foreach($data["modAccessResourceGroup"] as $key => $value){
    $w = array(
        "target" => $res_group[ "id".$value['target'] ],
        "principal" => $user_group[ "id".$value['principal'] ],
        "principal_class" => "modUserGroup",
        "policy" => 1,
        "context_key" => "web",
    );
    if (!($el = $modx->getObject('modAccessResourceGroup', $w))) {
        $el = $modx->newObject('modAccessResourceGroup', $w);
        $el->save();
    }
}

$templates = array();
foreach($club_modules as $categ) {
    $category = $modx->getObject('modCategory', array("category" => $categ));
    if (empty($category)) {
        $category = $modx->newObject('modCategory', array("category" => $categ));
        $category->save();
    }
    
    if (!empty($data["modSnippet_{$categ}"])) {
        foreach ($data["modSnippet_{$categ}"] as $name){
            $w = array('name' => $name);
            $el = $modx->getObject('modSnippet', $w);
            if (!$el) $el = $modx->newObject('modSnippet', $w);
            if (empty($el->get('static'))) {
                $el->fromArray([
                    //"source" => 1,
                    //"static" => 0,
                    //"static_file" => "",
                    "snippet" => file_get_contents("elements/snippet/{$name}.php"),
                    "category" => $category->id,
                ]);
                $el->save();
            }
        }
    }
    
    if (!empty($data["modChunk_{$categ}"])) {
        foreach ($data["modChunk_{$categ}"] as $name){
            $w = array('name' => $name);
            $el = $modx->getObject('modChunk', $w);
            if (!$el) $el = $modx->newObject('modChunk', $w);
            if (empty($el->get('static'))) {
                $el->fromArray([
                    //"source" => 1,
                    //"static" => 0,
                    //"static_file" => "",
                    "snippet" => file_get_contents("elements/chunk/{$name}.html"),
                    "category" => $category->id,
                ]);
                $el->save();
            }
        }
    }
    
    if (!empty($data["modTemplate_{$categ}"])) {
        foreach ($data["modTemplate_{$categ}"] as $name){
            $w = array('templatename' => $name);
            $el = $modx->getObject('modTemplate', $w);
            if (!$el) $el = $modx->newObject('modTemplate', $w);
            $el->fromArray([
                //"source" => 1,
                //"static" => 0,
                //"static_file" => "",
                "content" => file_get_contents("elements/tpl/{$name}.html"),
                "category" => $category->id,
            ]);
            $el->save();
            $templates[$name] = $el->get('id');
        }
    }
    
    if (!empty($data["modPlugin_{$categ}"])) {
        foreach ($data["modPlugin_{$categ}"] as $name){
            $w = array('name' => $name);
            $el = $modx->getObject('modPlugin', $w);
            if (!$el) $el = $modx->newObject('modPlugin', $w);
            $el->fromArray([
                //"source" => 1,
                //"static" => 0,
                //"static_file" => "",
                "plugincode" => file_get_contents("elements/plugin/{$name}.php"),
                "category" => $category->id,
            ]);
            $el->save();
            
            
            $PluginEvents = $data["PluginEvents_{$name}"];
            $elEvents = array();
            foreach($el->getMany('PluginEvents') as $pe){
                $event = $pe->get('event');
                $elEvents[] = $event;
                if (!in_array($event, $PluginEvents)) $pe->remove();
            }
            
            foreach ($PluginEvents as $plEvent) {
                if (in_array($plEvent, $elEvents)) continue;
                $mpev = $modx->newObject('modPluginEvent');
                $mpev->set('pluginid', $el->get('id'));
                $mpev->set('event', $plEvent);
                $mpev->save();
            }
        }
    }
    
}
    /* =========================== */
foreach($club_modules as $categ) {
    if (!empty($data["modResource_{$categ}"])) {
        $cntres = 0;
        foreach($data["modResource_{$categ}"] as $key => $res_data){
            echo "<br>Ищу {$res_data['id']}: {$res_data['pagetitle']}";
            
            $res_w = $local_res[ $res_data['id'] ]; // Поиск по ID из источника
            
            if (empty($res_w)) {
                echo " по uri {$res_data['uri']}.";
                $res_w = array('uri' => $res_data['uri']);
            }

            $res = $modx->getObject('modResource', $res_w);
            if (empty($res_data['parent'])) {
                $parent = 0;
            } else {
                $parent = $local_res[ $res_data['parent'] ];
                if (empty($parent)) $parent = -1;
            }
            echo " # Parent {$parent}";
            
            if (empty($res)) {
                if ($parent >= 0) {
                    echo " # Не нашел, создаю.";
                    $res = $modx->newObject('modResource', array(
                        //'parent' => $parent,
                        'published' => 1,
                        'menuindex' => $res_data['menuindex'],
                        'uri' => $res_data['uri'],
                    ));
                }
            } else {
                echo " # Нашел {$res->get('id')}";
            }
            
            if (!empty($res)) {
                if ($parent >= 0) {
                    $res->set('parent', $parent);
                }
                if (!empty($res_data['uri_override'])) {
                    array_push($fields, 'uri_override', 'uri');
                }
                $res->fromArray(array_intersect_key($res_data, array_flip($fields)));
                
                $res->set('content', file_get_contents("elements/res/{$res_data['id']}.html"));
                
                //$modx->log(modX::LOG_LEVEL_ERROR, "RRR ".$res_data['id']);
                
                $tpl = isset($res_data['Template'])? $templates[ $res_data['Template'] ] : 0;
                $res->set('template', $tpl);
                
                /*if (empty($res->get('club_id'))) {
                    $prop = $res->get('properties');
                    if (!empty($prop['club_id'])) {
                        $res->set('club_id', $prop['club_id']);
                    }
                }*/
                
                $res->save();
                $cntres++;

                $permiss = $data["modResourceGroupResource"][$key];
                if (!empty($permiss)) foreach($permiss as $old_group) {
                    $new_group = $res_group["id{$old_group}"];
                    $w = array(
                        "document" => $res->id,
                        "document_group" => $new_group,
                    );
                    $perm_obj = $modx->getObject('modResourceGroupResource', $w);
                    if (!$perm_obj) {
                        $perm_obj = $modx->newObject('modResourceGroupResource', $w);
                        $perm_obj->save();
                    }
                }
            }
        }
        echo "<br>{$categ}: update {$cntres} res";
    }
} // categ

$modx->updateCollection('modResource', array('deleted' => 1), array(
    'club_id:IN' => [174,181,169,180,163,135,29,194,58,206,203,16,20,211,198,202,208,209,207,172],
));
