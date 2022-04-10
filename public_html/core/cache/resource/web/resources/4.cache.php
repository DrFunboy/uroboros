<?php  return array (
  'resourceClass' => 'modDocument',
  'resource' => 
  array (
    'id' => 4,
    'type' => 'document',
    'contentType' => 'text/html',
    'pagetitle' => 'Реестр',
    'longtitle' => '',
    'description' => '',
    'alias' => 'reestr',
    'alias_visible' => 1,
    'link_attributes' => '',
    'published' => 1,
    'pub_date' => 0,
    'unpub_date' => 0,
    'parent' => 0,
    'isfolder' => 0,
    'introtext' => '',
    'content' => '<div class="section-block my-0">
    <table id="grid_idIncome" data-entity="idIncome"></table>
</div>

[[$tplFiles]]

<script>
var trainerData = { };

SCRM.loadWSS([\'ready\',\'grid\'], function () {

    $("#grid_idIncome")
    .one(\'jqGridBeforeInit\', function(e, grOpts){
        
    })
    .jqGridInit({
        sortname: \'name\', sortorder: \'asc\',
        search: true,
        postData: {
            //filters: SCRM.obj2Filter({published: \'1\'})
        },
        colModel:[
            {template: idFieldTemplate},
            {index: \'created\', label: \'Создан\',
                template:createdTemplate, hidden: false
            },
            {name:\'num\', label: \'Рег. номер\', hidden: false, width: 50},
            {name:\'status\', label: \'Статус\', editable: true, template: selTemplate,
                width: 100,
                clubStatus: \'idIncome\', lookupKey: \'id\'
            },
            {name:\'name\', label:\'Ф.И.О.\', width:200, editable: true, editrules:{required:true}},
            /*{name:\'gender\', label: \'Пол\', width:40, hidden: false, editable: true,
                editoptions: {
                    defaultValue: \'[[!clubConfig?name=`Gender_main`]]\'
                },
                formoptions:{rowpos:1, colpos:2},
                template: selTemplate,
                clubStatus: \'Gender\', lookupKey: \'alias\'
            },
            {name:\'birth\', label: \'Дата рождения\', editable: true,
                template: dateTemplate,
                fltrFunc: true // TODO: Что это?
            },*/              
            {template: telTemplate, editable: true},
            {name: \'email\', label: \'E-mail\', width:100, editable: true, editrules: {email: true, required: false}}, 
            {name: \'info\', label: \'Текст обращения\', width: 500,
                editable: true, editrules: {edithidden:true},
                template: infoTemplate
            },
            /*
            {name: \'categ\', label: \'Категория\', editable: true,
                template: selTemplate,
                clubStatus: \'TrainerCategory\', lookupKey: \'name\',
                dbvalues0: \'-\'
            },
            {name:\'referee\', label: \'Судья\', editable: true,
                template: selTemplate,
                clubStatus: \'TrainerRank\', lookupKey: \'name\',
                dbvalues0: \'-\'
            },*/
            [[-{name:\'sport\', label: \'Дисциплина\', editable: true, template: selTemplate,
                editoptions: {value: makeGridOpts(club_opts.idSport)},
                searchoptions: {value: makeGridOpts(club_opts.idSport, true)}
            },]]
        ],
        rowattr: function(data) {
            /*if (data.published != \'1\'){
                return {\'class\': \'rowArc\'};
            }*/
        },
        onSelectRow: function(rid,rr,ee) {
            var rdata = grids.idTrainer.jqGrid(\'getRowData\', rid);
            SCRM.link(formData, {
                id: rid,
                name: rdata.name,
                rdata: rdata
            });
        },
        navOpts: {add: false, edit:true, del:false}
    })
    .jqGrid(\'filterToolbar\')
    .jqGridColumns()
    .jqGridExport();

});
</script>

<script id="tpl_trainers" type="text/x-jsrender">
    <select class="custom-select" data-link="{:trainer:} class{merge:bad_trainer toggle=\'is-invalid\'}">
    <option value=""></option>
    {^{for idTrainer}}
        <option value="{{:id}}">{{:name}}</option>
    {{/for}}
    </select>
    <fieldset disabled1="disabled" class="form-group mt-2">
        <div class="custom-control custom-control-inline custom-radio">
            <input type="radio" class="custom-control-input" name="change_type" id="ct_repeat"
                value="repeat" data-link="change_mode">
            <label class="custom-control-label" for="ct_repeat">Постоянно</label>
        </div>
        <div class="custom-control custom-control-inline custom-radio">
            <input type="radio" class="custom-control-input" name="change_type" id="ct_once"
                value="once" data-link="change_mode">
            <label class="custom-control-label" for="ct_once">Временно</label>
        </div>
    </fieldset>
</script>

<script id="tpl_schEditor" type="text/x-jsrender">
<div class="mb-2 d-flex">
    <button class="btn btn-success btn-sm" data-link="{on \'click\' schEditorAdd}"><i class="fa fa-plus"></i></button>
    <div class="dropdown mx-1">
        <button data-toggle="dropdown" class="btn btn-primary btn-sm d-flex flex-nowrap align-items-center" data-link="disabled{:selRows^length==0}"
            disabled="disabled">Действия
            <small data-link="text{:selRows^length} visible{:selRows^length>0}" class="badge badge-pill badge-warning ml-1"></small>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-arrow"></div>
            <a href="#" class="dropdown-item" data-link="{on ~changeTrainer}">Сменить тренера</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" data-link="{on ~deleteSch}">Удалить</a>
        </div>
    </div>
    <button class="btn btn-secondary btn-sm" data-link="{on ~showFilter}"><i class="fa fa-filter"></i></button>
</div>
<div id="schEditorFltr" data-link="visible{:showFilter}"></div>
</script>

<script id="tpl_trainerCabinet" type="text/x-jsrender">
    <div class="d-flex justify-content-between align-items-center">
        <a href="#" target="_blank" data-link="href{:\'/trainer/lessons.html?trainer=\'+uid}">
            <i class="fa fa-sign-in"></i>
            <span data-link="html{:username || \'Кабинет\'}"></span>
        </a>
        <div class="card-title-control">
            {^{if !iduser}}
            <button class="btn btn-icon btn-light" data-link="{on ~idUser}"><i class="fa fa-key"></i></button>
            {{else}}
            <div class="dropdown">
                <button class="btn btn-icon btn-subtle-success" data-toggle="dropdown"><i class="fa fa-key"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-arrow"></div>
                    <a href="#" class="dropdown-item"
                        data-run="/chunk/forgotpassword" data-link="data-username{:username}">Восстановление пароля</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"
                        data-link="{on ~idUser}">Отключить</a>
                </div>
            </div>
            {{/if}}
            [[-<label class="switcher-control">
                <input type="checkbox" class="switcher-input" data-link="checked{:sp^iduser} {on \'change\' ~idUser}">
                <span class="switcher-indicator"></span>
            </label>]]
        </div>
    </div>
</script>

[[-var confirm_schdel = true;
    $(document).on(\'change\', \'#confirm_schdel\', function(){
        confirm_schdel = !$(this).prop(\'checked\');
    });]]
    
[[-<select id="h_start" class="form-control sel-hour"></select>
<select id="m_start" class="form-control sel-minute"></select>]]

[[-<input id="duration" class="form-control" size="3" value="45"> минут
<select id="h_end" class="form-control sel-hour"></select>
<select id="m_end" class="form-control sel-minute"></select>]]

[[-for (var t = 0; t <= 23; t++){
    var lzt = leadZero(t);
    $(\'.sel-hour\').append(\'<option value="\'+ lzt +\':">\'+ lzt +\':</option>\');
}
for (var t = 0; t <= 55; t += 5){
    var lzt = leadZero(t);
    $(\'.sel-minute\').append(\'<option value="\'+ lzt +\':00">\'+ lzt +\'</option>\');
}]]',
    'richtext' => 0,
    'template' => 2,
    'menuindex' => 3,
    'searchable' => 0,
    'cacheable' => 1,
    'createdby' => 1,
    'createdon' => 1649518927,
    'editedby' => 1,
    'editedon' => 1649584545,
    'deleted' => 0,
    'deletedon' => 0,
    'deletedby' => 0,
    'publishedon' => 1649518920,
    'publishedby' => 1,
    'menutitle' => '',
    'donthit' => 0,
    'privateweb' => 0,
    'privatemgr' => 0,
    'content_dispo' => 0,
    'hidemenu' => 0,
    'class_key' => 'modDocument',
    'context_key' => 'web',
    'content_type' => 1,
    'uri' => 'reestr.html',
    'uri_override' => 0,
    'hide_children_in_tree' => 0,
    'show_in_tree' => 1,
    'properties' => NULL,
    '_content' => '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    
    <title>Реестр | РосМедНадзор</title>

<link rel="stylesheet" href="/assets/id/wss/theme.min.css?v=1074" />

<script src="/assets/id/wss/jquery.min.js?ver=3.3.1"></script>
<script src="/js/[[!++scrm_prugv]]/start.js" id="start_js"></script>

[[!+StartupHTMLBlock]]
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
</head>
<body id="body4" class="spinner-parent" data-user="[[!+modx.user.id]]" data-mxq="[^q^]">
<div class="app">
    <nav class="app-header app-header-dark d-print-none start-data-link">
        <div class="top-bar">
            
            <a class="top-bar-brand" href="/">
                РосМедНадзор
            </a>
          <div class="top-bar-list">
            <div class="top-bar-item px-2 d-lg-none">
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="modal" data-target="#mmenuModal">
                    <span class="hamburger-inner"></span>
                </button>
            </div>
            <!-- .top-bar-item -->
            <div class="top-bar-item top-bar-item-right px-0">
              <ul class="header-nav nav">
                <li class="nav-item dropdown header-nav-dropdown1" id="scrmHelpMenu">
                    <a class="nav-link" href="#" data-toggle="dropdown"><span class="fa fa-question-circle"></span></a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-arrow"></div>
                        <a class="dropdown-item prevent-default" href="#" data-run="/chunk/help" data-help="kb">База знаний</a>
                        
                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item prevent-default" href="#" target="_blank" data-run="/chunk/help" data-help="about">О системе</a>
                        
                    </div>
                </li>
              </ul>
              <!-- .btn-account -->
              <div class="dropdown d-flex d-sm-flex1">
    [[!Login?
        &loginTpl=`idLoginMenu4`
        &logoutTpl=`idLogoutMenu4`
        &loginViaEmail=`1`
        &logoutResourceId=`1`
        &errTpl=`idLoginErrTpl`
    ]]
              </div><!-- /.btn-account -->
            </div><!-- /.top-bar-item -->
          </div><!-- /.top-bar-list -->
        </div><!-- /.top-bar -->
    </nav>

    <div id="page" class="d-flex min-vh-100">
        <aside class="border-right d-print-none d-none d-lg-block">
            <nav id="main-menu" class="mb-5">
            [[!clubMenu]]
            </nav>
        </aside>
        
        <main class="app-main1 flex-grow-1 d-flex flex-column">
            <div class="wrapper1 flex-grow-1">
              <div class="page1">
                <header class="page-navs shadow-sm pr-3 d-print-none start-data-link">
                    <div class="account-summary" data-link="visible{:!topNavTabs||!topNavTabs^length}">
                      <h2 class="card-title" data-link="html^{:title}">Реестр</h2>
                      <h6 class="card-subtitle text-muted" data-link="html^{:subtitle}"></h6>
                    </div>
                    <div class="nav-scroller" id="topNavTabs" data-link="visible{:topNavTabs^length}">
                        <div class="nav nav-tabs" data-link="{for topNavTabs tmpl=\'#tpl_topNavTab\'}"></div>
                    </div>
                  
                </header>
                <div class="page-inner">
                  
                  
                    <div class="page-section">
<div class="section-block my-0">
    <table id="grid_idIncome" data-entity="idIncome"></table>
</div>

[[$tplFiles]]

<script>
var trainerData = { };

SCRM.loadWSS([\'ready\',\'grid\'], function () {

    $("#grid_idIncome")
    .one(\'jqGridBeforeInit\', function(e, grOpts){
        
    })
    .jqGridInit({
        sortname: \'name\', sortorder: \'asc\',
        search: true,
        postData: {
            //filters: SCRM.obj2Filter({published: \'1\'})
        },
        colModel:[
            {template: idFieldTemplate},
            {index: \'created\', label: \'Создан\',
                template:createdTemplate, hidden: false
            },
            {name:\'num\', label: \'Рег. номер\', hidden: false, width: 50},
            {name:\'status\', label: \'Статус\', editable: true, template: selTemplate,
                width: 100,
                clubStatus: \'idIncome\', lookupKey: \'id\'
            },
            {name:\'name\', label:\'Ф.И.О.\', width:200, editable: true, editrules:{required:true}},
            /*{name:\'gender\', label: \'Пол\', width:40, hidden: false, editable: true,
                editoptions: {
                    defaultValue: \'[[!clubConfig?name=`Gender_main`]]\'
                },
                formoptions:{rowpos:1, colpos:2},
                template: selTemplate,
                clubStatus: \'Gender\', lookupKey: \'alias\'
            },
            {name:\'birth\', label: \'Дата рождения\', editable: true,
                template: dateTemplate,
                fltrFunc: true // TODO: Что это?
            },*/              
            {template: telTemplate, editable: true},
            {name: \'email\', label: \'E-mail\', width:100, editable: true, editrules: {email: true, required: false}}, 
            {name: \'info\', label: \'Текст обращения\', width: 500,
                editable: true, editrules: {edithidden:true},
                template: infoTemplate
            },
            /*
            {name: \'categ\', label: \'Категория\', editable: true,
                template: selTemplate,
                clubStatus: \'TrainerCategory\', lookupKey: \'name\',
                dbvalues0: \'-\'
            },
            {name:\'referee\', label: \'Судья\', editable: true,
                template: selTemplate,
                clubStatus: \'TrainerRank\', lookupKey: \'name\',
                dbvalues0: \'-\'
            },*/
            
        ],
        rowattr: function(data) {
            /*if (data.published != \'1\'){
                return {\'class\': \'rowArc\'};
            }*/
        },
        onSelectRow: function(rid,rr,ee) {
            var rdata = grids.idTrainer.jqGrid(\'getRowData\', rid);
            SCRM.link(formData, {
                id: rid,
                name: rdata.name,
                rdata: rdata
            });
        },
        navOpts: {add: false, edit:true, del:false}
    })
    .jqGrid(\'filterToolbar\')
    .jqGridColumns()
    .jqGridExport();

});
</script>

<script id="tpl_trainers" type="text/x-jsrender">
    <select class="custom-select" data-link="{:trainer:} class{merge:bad_trainer toggle=\'is-invalid\'}">
    <option value=""></option>
    {^{for idTrainer}}
        <option value="{{:id}}">{{:name}}</option>
    {{/for}}
    </select>
    <fieldset disabled1="disabled" class="form-group mt-2">
        <div class="custom-control custom-control-inline custom-radio">
            <input type="radio" class="custom-control-input" name="change_type" id="ct_repeat"
                value="repeat" data-link="change_mode">
            <label class="custom-control-label" for="ct_repeat">Постоянно</label>
        </div>
        <div class="custom-control custom-control-inline custom-radio">
            <input type="radio" class="custom-control-input" name="change_type" id="ct_once"
                value="once" data-link="change_mode">
            <label class="custom-control-label" for="ct_once">Временно</label>
        </div>
    </fieldset>
</script>

<script id="tpl_schEditor" type="text/x-jsrender">
<div class="mb-2 d-flex">
    <button class="btn btn-success btn-sm" data-link="{on \'click\' schEditorAdd}"><i class="fa fa-plus"></i></button>
    <div class="dropdown mx-1">
        <button data-toggle="dropdown" class="btn btn-primary btn-sm d-flex flex-nowrap align-items-center" data-link="disabled{:selRows^length==0}"
            disabled="disabled">Действия
            <small data-link="text{:selRows^length} visible{:selRows^length>0}" class="badge badge-pill badge-warning ml-1"></small>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-arrow"></div>
            <a href="#" class="dropdown-item" data-link="{on ~changeTrainer}">Сменить тренера</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" data-link="{on ~deleteSch}">Удалить</a>
        </div>
    </div>
    <button class="btn btn-secondary btn-sm" data-link="{on ~showFilter}"><i class="fa fa-filter"></i></button>
</div>
<div id="schEditorFltr" data-link="visible{:showFilter}"></div>
</script>

<script id="tpl_trainerCabinet" type="text/x-jsrender">
    <div class="d-flex justify-content-between align-items-center">
        <a href="#" target="_blank" data-link="href{:\'/trainer/lessons.html?trainer=\'+uid}">
            <i class="fa fa-sign-in"></i>
            <span data-link="html{:username || \'Кабинет\'}"></span>
        </a>
        <div class="card-title-control">
            {^{if !iduser}}
            <button class="btn btn-icon btn-light" data-link="{on ~idUser}"><i class="fa fa-key"></i></button>
            {{else}}
            <div class="dropdown">
                <button class="btn btn-icon btn-subtle-success" data-toggle="dropdown"><i class="fa fa-key"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-arrow"></div>
                    <a href="#" class="dropdown-item"
                        data-run="/chunk/forgotpassword" data-link="data-username{:username}">Восстановление пароля</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"
                        data-link="{on ~idUser}">Отключить</a>
                </div>
            </div>
            {{/if}}
            
        </div>
    </div>
</script>


    





                    </div>
                  
                  
                </div><!-- /.page-inner -->
              </div><!-- /.page -->
            </div><!-- /.wrapper -->
            
            <footer class="d-print-none bg^light border^top app-footer start-data-link">
                <ul class="list-inline" data-link="visible{:bottomNavLinks^length} {for bottomNavLinks ~itemCls=\'text-muted\' tmpl=\'#tplListInlineItem\'}"></ul>
                <div class="copyright">
                    &copy; Административная панель. Жалобы на Систему здравоохранения.
                </div>
            </footer>
        </main>
    </div>
</div>

<div class="modal inmodal1 fade" id="tpl_clubModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rmodalLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content spinner-parent" data-link="disabled{:loading}">
            <div class="color-line mb-3"></div>
            <div class="modal-header pt-0" data-link="visible{:title||!onOK}">
                <h5 class="modal-title" data-link="html{:title} id{:mdl_id+\'label\'}" id="rmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-3" data-link="{include tmpl=body}"></div>
            <div class="modal-footer pt-0" data-link="visible{:onOK||cancel||mdl_footer}">
                <div class="modal-footer-add flex-grow-1" data-link="{if mdl_footer tmpl=mdl_footer}"></div>
                <button type="button" class="btn btn-light btn-modal-cancel"
                    data-dismiss="modal"
                    data-link="html{:cancel? cancel:\'Отмена\'} visible{:onOK||cancel} disabled{:loading}"></button>
                <button type="button" class="btn btn-primary btn-modal-ok"
                    data-link="visible{:onOK} {on \'click\' ~on_OK} disabled{:loading||disabledOK}">
                    <span data-link="html{:ok||\'OK\'}"></span>
                    <span class="spinner-border spinner-border-sm" role="status" data-link="visible{:loading}"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-drawer fade" id="tpl_clubDrawer" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rdrawerLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog modal-drawer-right" role="document" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content" data-link="disabled{:loading}">
            <div class="modal-header d-flex">
                <div id="rdrawerLabel" class="modal-title h6 flex-grow-1" data-link="{include ^tmpl=title} id{:mdl_id+\'label\'}"></div>
                <button class="close d-print-none" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body my-2" data-link="{include tmpl=body}"></div>
        </div>
    </div>
</div>

<div class="modal modal-drawer fade" id="mmenuModal" tabindex="-1" role="dialog" aria-labelledby="mmenuLabel">
    <div class="modal-dialog modal-drawer-left" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b id="mmenuLabel" class="modal-title">[[!++site_name]]</b>
                <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0"></div>
        </div>
    </div>
</div>

<script id="roInplaceHtml" type="text/x-jsrender">
    <form action="" class="input-group roinplace" data-link="{on \'submit reset\' ~InplaceSubmit}">
        <input class="form-control" data-link="inplace_value">
        <div class="input-group-append" data-link="visible{:(inplace_value!=old_inplace_value)}">
            <button class="btn btn-subtle-primary" type="submit"><i class="fa fa-check"></i></button>
        </div>
        <div class="input-group-append">
            <button class="btn btn-subtle-danger" type="reset"><i class="fa fa-times"></i></button>
        </div>
    </form>
</script>

<script id="tplListInlineItem" type="text/x-jsrender">
    <li class="list-inline-item" data-link="{include tmpl=(!href)? #data : \'#tplMenuItem\'}"></li>
</script>
<script id="tplMenuItem" type="text/x-jsrender">
    <a data-link="html{:html} href{:href} class{:~itemCls||\'dropdown-item\'}"></a>
</script>
<script id="tpl_topNavTab" type="text/x-jsrender">
    <a class="nav-link" data-toggle="tab"
        data-link="html{:html} href{:href} class{merge:active toggle=\'active\'} visible{:!hidden}"></a>
</script>

<script>
    SCRM.app.title = \'Реестр\';
    $(\'.start-data-link\').link(true, SCRM.app);
</script>

<li class="nav-item ib-top">
    <a class="nav-link prevent-default" href="#" target="_blank"><i class="fa fa-user-plus"></i></a>
</li>


<script>
$(\'.ib-top\').prependTo(\'ul.header-nav\').find(\'a\').click(function(e){
    SCRM._run(\'/projects/widget\');
});
</script>



<script src="/assets/id/wss/bootstrap.js?ver=4.6.0"></script>
[[!+BottomHTMLBlock]]
</body>
</html>',
    '_isForward' => false,
  ),
  'contentType' => 
  array (
    'id' => 1,
    'name' => 'HTML',
    'description' => 'HTML content',
    'mime_type' => 'text/html',
    'file_extensions' => '.html',
    'headers' => NULL,
    'binary' => 0,
  ),
  'resourceGroups' => 
  array (
    3 => 
    array (
      'id' => 3,
      'document_group' => 1,
      'document' => 4,
    ),
  ),
  'policyCache' => 
  array (
    'modAccessResourceGroup' => 
    array (
      1 => 
      array (
        0 => 
        array (
          'principal' => '2',
          'authority' => '9999',
          'policy' => 
          array (
            'add_children' => true,
            'create' => true,
            'copy' => true,
            'delete' => true,
            'list' => true,
            'load' => true,
            'move' => true,
            'publish' => true,
            'remove' => true,
            'save' => true,
            'steal_lock' => true,
            'undelete' => true,
            'unpublish' => true,
            'view' => true,
          ),
        ),
      ),
    ),
  ),
  'elementCache' => 
  array (
    '[[$tplModal]]' => '<div class="modal inmodal1 fade" id="tpl_clubModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rmodalLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content spinner-parent" data-link="disabled{:loading}">
            <div class="color-line mb-3"></div>
            <div class="modal-header pt-0" data-link="visible{:title||!onOK}">
                <h5 class="modal-title" data-link="html{:title} id{:mdl_id+\'label\'}" id="rmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-3" data-link="{include tmpl=body}"></div>
            <div class="modal-footer pt-0" data-link="visible{:onOK||cancel||mdl_footer}">
                <div class="modal-footer-add flex-grow-1" data-link="{if mdl_footer tmpl=mdl_footer}"></div>
                <button type="button" class="btn btn-light btn-modal-cancel"
                    data-dismiss="modal"
                    data-link="html{:cancel? cancel:\'Отмена\'} visible{:onOK||cancel} disabled{:loading}"></button>
                <button type="button" class="btn btn-primary btn-modal-ok"
                    data-link="visible{:onOK} {on \'click\' ~on_OK} disabled{:loading||disabledOK}">
                    <span data-link="html{:ok||\'OK\'}"></span>
                    <span class="spinner-border spinner-border-sm" role="status" data-link="visible{:loading}"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-drawer fade" id="tpl_clubDrawer" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rdrawerLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog modal-drawer-right" role="document" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content" data-link="disabled{:loading}">
            <div class="modal-header d-flex">
                <div id="rdrawerLabel" class="modal-title h6 flex-grow-1" data-link="{include ^tmpl=title} id{:mdl_id+\'label\'}"></div>
                <button class="close d-print-none" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body my-2" data-link="{include tmpl=body}"></div>
        </div>
    </div>
</div>',
  ),
  'sourceCache' => 
  array (
    'modChunk' => 
    array (
      'tplModal' => 
      array (
        'fields' => 
        array (
          'id' => 15,
          'source' => 1,
          'property_preprocess' => false,
          'name' => 'tplModal',
          'description' => '',
          'editor_type' => 0,
          'category' => 0,
          'cache_type' => 0,
          'snippet' => '<div class="modal inmodal1 fade" id="tpl_clubModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rmodalLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content spinner-parent" data-link="disabled{:loading}">
            <div class="color-line mb-3"></div>
            <div class="modal-header pt-0" data-link="visible{:title||!onOK}">
                <h5 class="modal-title" data-link="html{:title} id{:mdl_id+\'label\'}" id="rmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-3" data-link="{include tmpl=body}"></div>
            <div class="modal-footer pt-0" data-link="visible{:onOK||cancel||mdl_footer}">
                <div class="modal-footer-add flex-grow-1" data-link="{if mdl_footer tmpl=mdl_footer}"></div>
                <button type="button" class="btn btn-light btn-modal-cancel"
                    data-dismiss="modal"
                    data-link="html{:cancel? cancel:\'Отмена\'} visible{:onOK||cancel} disabled{:loading}"></button>
                <button type="button" class="btn btn-primary btn-modal-ok"
                    data-link="visible{:onOK} {on \'click\' ~on_OK} disabled{:loading||disabledOK}">
                    <span data-link="html{:ok||\'OK\'}"></span>
                    <span class="spinner-border spinner-border-sm" role="status" data-link="visible{:loading}"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-drawer fade" id="tpl_clubDrawer" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rdrawerLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog modal-drawer-right" role="document" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content" data-link="disabled{:loading}">
            <div class="modal-header d-flex">
                <div id="rdrawerLabel" class="modal-title h6 flex-grow-1" data-link="{include ^tmpl=title} id{:mdl_id+\'label\'}"></div>
                <button class="close d-print-none" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body my-2" data-link="{include tmpl=body}"></div>
        </div>
    </div>
</div>',
          'locked' => false,
          'properties' => 
          array (
          ),
          'static' => false,
          'static_file' => '',
          'content' => '<div class="modal inmodal1 fade" id="tpl_clubModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rmodalLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content spinner-parent" data-link="disabled{:loading}">
            <div class="color-line mb-3"></div>
            <div class="modal-header pt-0" data-link="visible{:title||!onOK}">
                <h5 class="modal-title" data-link="html{:title} id{:mdl_id+\'label\'}" id="rmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-3" data-link="{include tmpl=body}"></div>
            <div class="modal-footer pt-0" data-link="visible{:onOK||cancel||mdl_footer}">
                <div class="modal-footer-add flex-grow-1" data-link="{if mdl_footer tmpl=mdl_footer}"></div>
                <button type="button" class="btn btn-light btn-modal-cancel"
                    data-dismiss="modal"
                    data-link="html{:cancel? cancel:\'Отмена\'} visible{:onOK||cancel} disabled{:loading}"></button>
                <button type="button" class="btn btn-primary btn-modal-ok"
                    data-link="visible{:onOK} {on \'click\' ~on_OK} disabled{:loading||disabledOK}">
                    <span data-link="html{:ok||\'OK\'}"></span>
                    <span class="spinner-border spinner-border-sm" role="status" data-link="visible{:loading}"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-drawer fade" id="tpl_clubDrawer" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="rdrawerLabel" data-link="aria-labelledby{:mdl_id+\'label\'}">
    <div class="modal-dialog modal-drawer-right" role="document" data-link="class{merge:cm_size toggle=\'modal-\'+cm_size}">
        <div class="modal-content" data-link="disabled{:loading}">
            <div class="modal-header d-flex">
                <div id="rdrawerLabel" class="modal-title h6 flex-grow-1" data-link="{include ^tmpl=title} id{:mdl_id+\'label\'}"></div>
                <button class="close d-print-none" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body my-2" data-link="{include tmpl=body}"></div>
        </div>
    </div>
</div>',
        ),
        'policies' => 
        array (
        ),
        'source' => 
        array (
          'id' => 1,
          'name' => 'Filesystem',
          'description' => '',
          'class_key' => 'sources.modFileMediaSource',
          'properties' => 
          array (
          ),
          'is_stream' => true,
        ),
      ),
      'idLogoutMenu4' => 
      array (
        'fields' => 
        array (
          'id' => 13,
          'source' => 1,
          'property_preprocess' => false,
          'name' => 'idLogoutMenu4',
          'description' => '',
          'editor_type' => 0,
          'category' => 0,
          'cache_type' => 0,
          'snippet' => '<button class="btn-account" type="button" data-toggle="dropdown"[[- data-display="static" aria-haspopup="true" aria-expanded="false"]]>
    <span class="d-block d-md-none">
        <i class="fa fa-user-circle-o"></i>
    </span>
    <span class="account-summary d-none d-md-block">
        <span class="account-name">[[!#SESSION.user_fullname]]</span>
        [[-<span class="account-description">[[-!#SESSION.club_cityname]]</span>]]
    </span>
</button>
<!-- .dropdown-menu -->
<div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-arrow"></div>
    <h6 class="dropdown-header d-md-none" id="user_fullname">[[!#SESSION.user_fullname]]</h6>
    <a class="dropdown-item" href="/login/profile.html"><i class="dropdown-icon fa fa-id-card-o"></i> Профиль</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="[[+logoutUrl]]"><i class="dropdown-icon fa fa-sign-out"></i> Выход</a>
</div>
<!-- /.dropdown-menu -->
[[-#SESSION.club_manager:notempty=`
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="chCity" aria-expanded="false">
        <i class="fa fa-map-marker"></i> 
        [[-#SESSION.club_cityname]]
        <span class="caret"></span>
    </a>
    
    <ul class="dropdown-menu">
        <li><a href="/database/db.html">База данных</a></li>
    </ul>
</li>
`]]',
          'locked' => false,
          'properties' => 
          array (
          ),
          'static' => false,
          'static_file' => '',
          'content' => '<button class="btn-account" type="button" data-toggle="dropdown"[[- data-display="static" aria-haspopup="true" aria-expanded="false"]]>
    <span class="d-block d-md-none">
        <i class="fa fa-user-circle-o"></i>
    </span>
    <span class="account-summary d-none d-md-block">
        <span class="account-name">[[!#SESSION.user_fullname]]</span>
        [[-<span class="account-description">[[-!#SESSION.club_cityname]]</span>]]
    </span>
</button>
<!-- .dropdown-menu -->
<div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-arrow"></div>
    <h6 class="dropdown-header d-md-none" id="user_fullname">[[!#SESSION.user_fullname]]</h6>
    <a class="dropdown-item" href="/login/profile.html"><i class="dropdown-icon fa fa-id-card-o"></i> Профиль</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="[[+logoutUrl]]"><i class="dropdown-icon fa fa-sign-out"></i> Выход</a>
</div>
<!-- /.dropdown-menu -->
[[-#SESSION.club_manager:notempty=`
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="chCity" aria-expanded="false">
        <i class="fa fa-map-marker"></i> 
        [[-#SESSION.club_cityname]]
        <span class="caret"></span>
    </a>
    
    <ul class="dropdown-menu">
        <li><a href="/database/db.html">База данных</a></li>
    </ul>
</li>
`]]',
        ),
        'policies' => 
        array (
        ),
        'source' => 
        array (
          'id' => 1,
          'name' => 'Filesystem',
          'description' => '',
          'class_key' => 'sources.modFileMediaSource',
          'properties' => 
          array (
          ),
          'is_stream' => true,
        ),
      ),
    ),
    'modSnippet' => 
    array (
      'Login' => 
      array (
        'fields' => 
        array (
          'id' => 16,
          'source' => 0,
          'property_preprocess' => false,
          'name' => 'Login',
          'description' => 'Displays a login and logout form.',
          'editor_type' => 0,
          'category' => 3,
          'cache_type' => 0,
          'snippet' => '/**
 * Login
 *
 * Copyright 2010 by Jason Coward <jason@modx.com> and Shaun McCormick
 * <shaun@modx.com>
 *
 * Login is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Login is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Login; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package login
 */
/**
 * MODx Login Snippet
 *
 * This snippet handles login POSTs, sending the user back to where they came from or to a specific
 * location if specified in the POST.
 *
 * @package login
 *
 * @property textfield actionKey The REQUEST variable containing the action to take.
 * @property textfield loginKey The actionKey for login.
 * @property textfield logoutKey The actionKey for logout.
 * @property boolean loginViaEmail Enable login via username or email address (either one!) [default: false]
 * @property list tplType The type of template to expect for the views:
 *  modChunk - name of chunk to use
 *  file - full path to file to use as tpl
 *  embedded - the tpl is embedded in the page content
 *  inline - the tpl is inline content provided directly
 * @property textfield loginTpl The template for the login view (content based on tplType)
 * @property textfield logoutTpl The template for the logout view (content based on tplType)
 * @property textfield errTpl The template for any errors that occur when processing an view
 * @property list errTplType The type of template to expect for the error messages:
 *  modChunk - name of chunk to use
 *  file - full path to file to use as tpl
 *  inline - the tpl is inline content provided directly
 * @property integer logoutResourceId An explicit resource id to redirect users to on logout
 * @property string loginMsg The string to use for the login action. Defaults to
 * the lexicon string "login".
 * @property string logoutMsg The string to use for the logout action. Defaults
 * to the lexicon string "login.logout"
 */
require_once $modx->getOption(\'login.core_path\',null,$modx->getOption(\'core_path\').\'components/login/\').\'model/login/login.class.php\';
$login = new Login($modx,$scriptProperties);
if (!is_object($login) || !($login instanceof Login)) return \'\';

$controller = $login->loadController(\'Login\');
$output = $controller->run($scriptProperties);
return $output;',
          'locked' => false,
          'properties' => 
          array (
            'actionKey' => 
            array (
              'name' => 'actionKey',
              'desc' => 'prop_login.actionkey_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'service',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Переменная REQUEST, которая указывает, какое действие предпринять.',
              'area_trans' => '',
            ),
            'loginKey' => 
            array (
              'name' => 'loginKey',
              'desc' => 'prop_login.loginkey_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'login',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Ключ действия входа.',
              'area_trans' => '',
            ),
            'logoutKey' => 
            array (
              'name' => 'logoutKey',
              'desc' => 'prop_login.logoutkey_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'logout',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Ключ действия выхода.',
              'area_trans' => '',
            ),
            'loginViaEmail' => 
            array (
              'name' => 'loginViaEmail',
              'desc' => 'prop_login.loginviaemail_desc',
              'type' => 'combo-boolean',
              'options' => '',
              'value' => false,
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Включение входа через имя пользователя или адрес электронной почты.',
              'area_trans' => '',
            ),
            'tplType' => 
            array (
              'name' => 'tplType',
              'desc' => 'prop_login.tpltype_desc',
              'type' => 'list',
              'options' => 
              array (
                0 => 
                array (
                  'value' => 'modChunk',
                  'text' => 'opt_register.chunk',
                  'name' => 'Чанк',
                ),
                1 => 
                array (
                  'value' => 'file',
                  'text' => 'opt_register.file',
                  'name' => 'Файл',
                ),
                2 => 
                array (
                  'value' => 'inline',
                  'text' => 'opt_register.inline',
                  'name' => 'Встроенный',
                ),
                3 => 
                array (
                  'value' => 'embedded',
                  'text' => 'opt_register.embedded',
                  'name' => 'Встроенное',
                ),
              ),
              'value' => 'modChunk',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Тип tpls, который предоставляется для формы входа и выхода.',
              'area_trans' => '',
            ),
            'loginTpl' => 
            array (
              'name' => 'loginTpl',
              'desc' => 'prop_login.logintpl_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'lgnLoginTpl',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Форма входа tpl.',
              'area_trans' => '',
            ),
            'logoutTpl' => 
            array (
              'name' => 'logoutTpl',
              'desc' => 'prop_login.logouttpl_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'lgnLogoutTpl',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Выход tpl.',
              'area_trans' => '',
            ),
            'preHooks' => 
            array (
              'name' => 'preHooks',
              'desc' => 'prop_login.prehooks_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Какие скрипты нужно запустить, если они есть, перед тем, как пользователь войдет в систему или выйдет из нее. Это может быть список хуков, разделенных запятыми, и если первый хук выполнить не получится, все последующие также не сработают. Хук, также, может являться именем сниппета, который будет выполнять этот снимет.',
              'area_trans' => '',
            ),
            'postHooks' => 
            array (
              'name' => 'postHooks',
              'desc' => 'prop_login.posthooks_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Какие скрипты нужно запустить, если они есть, после того, как пользователь войдет в систему или выйдет из нее. Это может быть список хуков, разделенных запятыми, и если первый хук выполнить не получится, все последующие также не сработают. Хук, также, может являться именем сниппета, который будет выполнять этот сниппет.',
              'area_trans' => '',
            ),
            'errTpl' => 
            array (
              'name' => 'errTpl',
              'desc' => 'prop_login.errtpl_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'lgnErrTpl',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Ошибка tpl.',
              'area_trans' => '',
            ),
            'errTplType' => 
            array (
              'name' => 'errTplType',
              'desc' => 'prop_login.errtpltype_desc',
              'type' => 'list',
              'options' => 
              array (
                0 => 
                array (
                  'value' => 'modChunk',
                  'text' => 'opt_register.chunk',
                  'name' => 'Чанк',
                ),
                1 => 
                array (
                  'value' => 'file',
                  'text' => 'opt_register.file',
                  'name' => 'Файл',
                ),
                2 => 
                array (
                  'value' => 'inline',
                  'text' => 'opt_register.inline',
                  'name' => 'Встроенный',
                ),
                3 => 
                array (
                  'value' => 'embedded',
                  'text' => 'opt_register.embedded',
                  'name' => 'Встроенное',
                ),
              ),
              'value' => 'modChunk',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Тип ошибки tpl.',
              'area_trans' => '',
            ),
            'loginResourceId' => 
            array (
              'name' => 'loginResourceId',
              'desc' => 'prop_login.loginresourceid_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '0',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Ресурс для перенаправления пользователей на успешный вход в систему. Значение 0 перенаправит на себя.',
              'area_trans' => '',
            ),
            'loginResourceParams' => 
            array (
              'name' => 'loginResourceParams',
              'desc' => 'prop_login.loginresourceparams_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Массив JSON параметров для добавления в URL при перенаправлении на авторизацию. Пример: {"test":123}',
              'area_trans' => '',
            ),
            'logoutResourceId' => 
            array (
              'name' => 'logoutResourceId',
              'desc' => 'prop_login.logoutresourceid_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '0',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'ID ресурса для перенаправления пользователей на успешный выход из системы. Значение 0 перенаправит на себя.',
              'area_trans' => '',
            ),
            'logoutResourceParams' => 
            array (
              'name' => 'logoutResourceParams',
              'desc' => 'prop_login.logoutresourceparams_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Массив JSON параметров для добавления в URL при перенаправлении на разавторизацию. Пример: {"test":123}',
              'area_trans' => '',
            ),
            'loginMsg' => 
            array (
              'name' => 'loginMsg',
              'desc' => 'prop_login.loginmsg_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Необязательное сообщение для авторизации. Если пустое, будет использоваться строка словаря для входа.',
              'area_trans' => '',
            ),
            'logoutMsg' => 
            array (
              'name' => 'logoutMsg',
              'desc' => 'prop_login.logoutmsg_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Необязательное сообщение для разавторизации. Если пустое, будет использоваться строка словаря для выхода.',
              'area_trans' => '',
            ),
            'redirectToPrior' => 
            array (
              'name' => 'redirectToPrior',
              'desc' => 'prop_login.redirecttoprior_desc',
              'type' => 'combo-boolean',
              'options' => '',
              'value' => false,
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Если установлено значение "Да", при успешном входе перенаправляется на страницу,с которой был осуществлен переход (HTTP_REFER).',
              'area_trans' => '',
            ),
            'redirectToOnFailedAuth' => 
            array (
              'name' => 'redirectToOnFailedAuth',
              'desc' => 'prop_login.redirecttoonfailedauth_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Если установлено ненулевое число, то пользователь будет перенаправлен на эту страницу, если его попытка авторизации не удалась.',
              'area_trans' => '',
            ),
            'rememberMeKey' => 
            array (
              'name' => 'rememberMeKey',
              'desc' => 'prop_login.remembermekey_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => 'rememberme',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Необязательно. Имя поля переключателя "Запомнить меня", чтобы сохранить состояние авторизации. По умолчанию `rememberme`.',
              'area_trans' => '',
            ),
            'contexts' => 
            array (
              'name' => 'contexts',
              'desc' => 'prop_login.contexts_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => '(Экспериментально) Список контекстов для авторизации, разделенных запятыми. По умолчанию текущий контекст, если явно не задан.',
              'area_trans' => '',
            ),
            'toPlaceholder' => 
            array (
              'name' => 'toPlaceholder',
              'desc' => 'prop_login.toplaceholder_desc',
              'type' => 'textfield',
              'options' => '',
              'value' => '',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Если указано, вывод сниппета будет устанавливаться на плейсхолдер этого имени вместо непосредственного вывода возвращаемого содержимого.',
              'area_trans' => '',
            ),
            'recaptchaTheme' => 
            array (
              'name' => 'recaptchaTheme',
              'desc' => 'prop_register.recaptchaTheme_desc',
              'type' => 'list',
              'options' => 
              array (
                0 => 
                array (
                  'value' => 'red',
                  'text' => 'opt_register.red',
                  'name' => 'Красный',
                ),
                1 => 
                array (
                  'value' => 'white',
                  'text' => 'opt_register.white',
                  'name' => 'Белый',
                ),
                2 => 
                array (
                  'value' => 'clean',
                  'text' => 'opt_register.clean',
                  'name' => 'Чистый',
                ),
                3 => 
                array (
                  'value' => 'blackglass',
                  'text' => 'opt_register.blackglass',
                  'name' => 'Чёрное Стекло',
                ),
              ),
              'value' => 'clean',
              'lexicon' => 'login:properties',
              'area' => '',
              'desc_trans' => 'Если `recaptcha` установлен как preHook, это значение выберет тему для виджета reCaptcha.',
              'area_trans' => '',
            ),
          ),
          'moduleguid' => '',
          'static' => false,
          'static_file' => '',
          'content' => '/**
 * Login
 *
 * Copyright 2010 by Jason Coward <jason@modx.com> and Shaun McCormick
 * <shaun@modx.com>
 *
 * Login is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Login is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Login; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package login
 */
/**
 * MODx Login Snippet
 *
 * This snippet handles login POSTs, sending the user back to where they came from or to a specific
 * location if specified in the POST.
 *
 * @package login
 *
 * @property textfield actionKey The REQUEST variable containing the action to take.
 * @property textfield loginKey The actionKey for login.
 * @property textfield logoutKey The actionKey for logout.
 * @property boolean loginViaEmail Enable login via username or email address (either one!) [default: false]
 * @property list tplType The type of template to expect for the views:
 *  modChunk - name of chunk to use
 *  file - full path to file to use as tpl
 *  embedded - the tpl is embedded in the page content
 *  inline - the tpl is inline content provided directly
 * @property textfield loginTpl The template for the login view (content based on tplType)
 * @property textfield logoutTpl The template for the logout view (content based on tplType)
 * @property textfield errTpl The template for any errors that occur when processing an view
 * @property list errTplType The type of template to expect for the error messages:
 *  modChunk - name of chunk to use
 *  file - full path to file to use as tpl
 *  inline - the tpl is inline content provided directly
 * @property integer logoutResourceId An explicit resource id to redirect users to on logout
 * @property string loginMsg The string to use for the login action. Defaults to
 * the lexicon string "login".
 * @property string logoutMsg The string to use for the logout action. Defaults
 * to the lexicon string "login.logout"
 */
require_once $modx->getOption(\'login.core_path\',null,$modx->getOption(\'core_path\').\'components/login/\').\'model/login/login.class.php\';
$login = new Login($modx,$scriptProperties);
if (!is_object($login) || !($login instanceof Login)) return \'\';

$controller = $login->loadController(\'Login\');
$output = $controller->run($scriptProperties);
return $output;',
        ),
        'policies' => 
        array (
        ),
        'source' => 
        array (
        ),
      ),
      'clubMenu' => 
      array (
        'fields' => 
        array (
          'id' => 21,
          'source' => 1,
          'property_preprocess' => false,
          'name' => 'clubMenu',
          'description' => '',
          'editor_type' => 0,
          'category' => 0,
          'cache_type' => 0,
          'snippet' => '$menuGroups = $modx->getOption(\'scrm_grhash\');
$id = $modx->resource->get(\'id\');

$cache_path = CRM_PREFIX."/clubMenu/{$menuGroups}_".$id;
$menu = $modx->cacheManager->get($cache_path);
if (empty($menu)) {
    foreach($modx->getOption(\'club_modules\') as $midx => $module) {
        $menuWhere[] = \'"\'.$midx.\'":{"\'.
        (($midx==0)? \'\':\'OR:\').
        \'link_attributes:LIKE":"%\'. $module .\'%"}\';
    }
    $menuWhere = \'{ "0":{\'. implode(\',\', $menuWhere) .\' } }\';
    $menu = $modx->runSnippet(\'pdoMenu\', array(
        \'level\' => 2,
        \'scheme\' => \'abs\',
        \'useWeblinkUrl\' => 1,
        \'parents\' => 0,
        \'firstClass\' => 0,
        \'lastClass\' => 0,
        \'checkPermissions\' => \'list\',
        //\'where\' => $menuWhere,
        //\'where\' => \'{"0":{"0":{"link_attributes:LIKE":"%clubStuff%"}, "1":{"OR:link_attributes:LIKE":"%clubShop1%"} } }\',
        \'showLog\' => 0,
        \'tplParentRow\' => \'@INLINE <li[[+classes]] id="menuitem[[+id]]">
        <a href="#menuwrapper[[+id]]" class="nav-link collapsed" data-toggle="collapse" [[+attributes]]>[[+menutitle]]</a>
        <div id="menuwrapper[[+id]]" class="collapse" data-parent="#left-menu">
        <ul class="nav flex-column">[[+wrapper]]</ul>
        </div>
        </li>\',
        \'tpl\' => \'@INLINE <li[[+classes]] id="mmenuitem[[+id]]"><a href="[[+link]]"[[+attributes]] class="nav-link">[[+menutitle]]</a>[[+wrapper]]</li>\',
        
        \'tplInner\' => \'@INLINE [[+wrapper]]\',
        \'tplOuter\' => \'@INLINE <ul id="left-menu" class="nav nav-pills flex-column">[[+wrapper]]</ul>\',
        \'rowClass\' => \'nav-item\',
    ));

    $modx->cacheManager->set($cache_path, $menu, 1000); //7 дней // 604800
}
return $menu;

/*
[[!pdoMenu?
    
    &parents=`0`
    &firstClass=`0` &lastClass=`0`
    
    &checkPermissions=`list`
    &cache=`1`
    &cache_key=`club_[[!#SESSION.club_groups]]`

    &tplParentRow=`@INLINE <li[[+classes]]>
        <a href="#menu[[+id]]" class="nav-link collapsed" data-toggle="collapse" [[+attributes]]>[[+menutitle]]</a>
        <div id="menu[[+id]]" class="collapse" data-parent="#left-menu">
        <ul class="nav flex-column">[[+wrapper]]</ul>
        </div>
    </li>`
    &tpl=`@INLINE <li[[+classes]]><a href="[[+link]]"[[+attributes]] class="nav-link">[[+menutitle]]</a>[[+wrapper]]</li>`
    &rowClass=`nav-item`
    &tplInner=`@INLINE [[+wrapper]]`
    &tplOuter=`@INLINE <ul id="left-menu" class="nav nav-pills flex-column">[[+wrapper]]</ul>`
    
    &showLog=`0`
]]
*/',
          'locked' => false,
          'properties' => 
          array (
          ),
          'moduleguid' => '',
          'static' => false,
          'static_file' => '',
          'content' => '$menuGroups = $modx->getOption(\'scrm_grhash\');
$id = $modx->resource->get(\'id\');

$cache_path = CRM_PREFIX."/clubMenu/{$menuGroups}_".$id;
$menu = $modx->cacheManager->get($cache_path);
if (empty($menu)) {
    foreach($modx->getOption(\'club_modules\') as $midx => $module) {
        $menuWhere[] = \'"\'.$midx.\'":{"\'.
        (($midx==0)? \'\':\'OR:\').
        \'link_attributes:LIKE":"%\'. $module .\'%"}\';
    }
    $menuWhere = \'{ "0":{\'. implode(\',\', $menuWhere) .\' } }\';
    $menu = $modx->runSnippet(\'pdoMenu\', array(
        \'level\' => 2,
        \'scheme\' => \'abs\',
        \'useWeblinkUrl\' => 1,
        \'parents\' => 0,
        \'firstClass\' => 0,
        \'lastClass\' => 0,
        \'checkPermissions\' => \'list\',
        //\'where\' => $menuWhere,
        //\'where\' => \'{"0":{"0":{"link_attributes:LIKE":"%clubStuff%"}, "1":{"OR:link_attributes:LIKE":"%clubShop1%"} } }\',
        \'showLog\' => 0,
        \'tplParentRow\' => \'@INLINE <li[[+classes]] id="menuitem[[+id]]">
        <a href="#menuwrapper[[+id]]" class="nav-link collapsed" data-toggle="collapse" [[+attributes]]>[[+menutitle]]</a>
        <div id="menuwrapper[[+id]]" class="collapse" data-parent="#left-menu">
        <ul class="nav flex-column">[[+wrapper]]</ul>
        </div>
        </li>\',
        \'tpl\' => \'@INLINE <li[[+classes]] id="mmenuitem[[+id]]"><a href="[[+link]]"[[+attributes]] class="nav-link">[[+menutitle]]</a>[[+wrapper]]</li>\',
        
        \'tplInner\' => \'@INLINE [[+wrapper]]\',
        \'tplOuter\' => \'@INLINE <ul id="left-menu" class="nav nav-pills flex-column">[[+wrapper]]</ul>\',
        \'rowClass\' => \'nav-item\',
    ));

    $modx->cacheManager->set($cache_path, $menu, 1000); //7 дней // 604800
}
return $menu;

/*
[[!pdoMenu?
    
    &parents=`0`
    &firstClass=`0` &lastClass=`0`
    
    &checkPermissions=`list`
    &cache=`1`
    &cache_key=`club_[[!#SESSION.club_groups]]`

    &tplParentRow=`@INLINE <li[[+classes]]>
        <a href="#menu[[+id]]" class="nav-link collapsed" data-toggle="collapse" [[+attributes]]>[[+menutitle]]</a>
        <div id="menu[[+id]]" class="collapse" data-parent="#left-menu">
        <ul class="nav flex-column">[[+wrapper]]</ul>
        </div>
    </li>`
    &tpl=`@INLINE <li[[+classes]]><a href="[[+link]]"[[+attributes]] class="nav-link">[[+menutitle]]</a>[[+wrapper]]</li>`
    &rowClass=`nav-item`
    &tplInner=`@INLINE [[+wrapper]]`
    &tplOuter=`@INLINE <ul id="left-menu" class="nav nav-pills flex-column">[[+wrapper]]</ul>`
    
    &showLog=`0`
]]
*/',
        ),
        'policies' => 
        array (
        ),
        'source' => 
        array (
          'id' => 1,
          'name' => 'Filesystem',
          'description' => '',
          'class_key' => 'sources.modFileMediaSource',
          'properties' => 
          array (
          ),
          'is_stream' => true,
        ),
      ),
      'pdoMenu' => 
      array (
        'fields' => 
        array (
          'id' => 8,
          'source' => 1,
          'property_preprocess' => false,
          'name' => 'pdoMenu',
          'description' => '',
          'editor_type' => 0,
          'category' => 2,
          'cache_type' => 0,
          'snippet' => '/** @var array $scriptProperties */
/** @var modX $modx */

// Convert parameters from Wayfinder if exists
if (isset($startId)) {
    $scriptProperties[\'parents\'] = $startId;
}
if (!empty($includeDocs)) {
    $tmp = array_map(\'trim\', explode(\',\', $includeDocs));
    foreach ($tmp as $v) {
        if (!empty($scriptProperties[\'resources\'])) {
            $scriptProperties[\'resources\'] .= \',\' . $v;
        } else {
            $scriptProperties[\'resources\'] = $v;
        }
    }
}
if (!empty($excludeDocs)) {
    $tmp = array_map(\'trim\', explode(\',\', $excludeDocs));
    foreach ($tmp as $v) {
        if (!empty($scriptProperties[\'resources\'])) {
            $scriptProperties[\'resources\'] .= \',-\' . $v;
        } else {
            $scriptProperties[\'resources\'] = \'-\' . $v;
        }
    }
}

if (!empty($previewUnpublished) && $modx->hasPermission(\'view_unpublished\')) {
    $scriptProperties[\'showUnpublished\'] = 1;
}

$scriptProperties[\'depth\'] = empty($level) ? 100 : abs($level) - 1;
if (!empty($contexts)) {
    $scriptProperties[\'context\'] = $contexts;
}
if (empty($scriptProperties[\'context\'])) {
    $scriptProperties[\'context\'] = $modx->resource->context_key;
}

// Save original parents specified by user
$specified_parents = array_map(\'trim\', explode(\',\', $scriptProperties[\'parents\']));

if ($scriptProperties[\'parents\'] === \'\') {
    $scriptProperties[\'parents\'] = $modx->resource->id;
} elseif ($scriptProperties[\'parents\'] === 0 || $scriptProperties[\'parents\'] === \'0\') {
    if ($scriptProperties[\'depth\'] !== \'\' && $scriptProperties[\'depth\'] !== 100) {
        $contexts = array_map(\'trim\', explode(\',\', $scriptProperties[\'context\']));
        $parents = array();
        if (!empty($scriptProperties[\'showDeleted\'])) {
            /** @var pdoFetch $pdoFetch */
            $pdoFetch = $modx->getService(\'pdoFetch\');
            foreach ($contexts as $ctx) {
                $parents = array_merge($parents, $pdoFetch->getChildIds(\'modResource\', 0, $scriptProperties[\'depth\'], array(\'context\' => $ctx)));
            }
        } else {
            foreach ($contexts as $ctx) {
                $parents = array_merge($parents, $modx->getChildIds(0, $scriptProperties[\'depth\'], array(\'context\' => $ctx)));
            }
        }
        $scriptProperties[\'parents\'] = !empty($parents) ? implode(\',\', $parents) : \'+0\';
        $scriptProperties[\'depth\'] = 0;
    }
    $scriptProperties[\'includeParents\'] = 1;
    $scriptProperties[\'displayStart\'] = 0;
} else {
    $parents = array_map(\'trim\', explode(\',\', $scriptProperties[\'parents\']));
    $parents_in = $parents_out = array();
    foreach ($parents as $v) {
        if (!is_numeric($v)) {
            continue;
        }
        if ($v[0] == \'-\') {
            $parents_out[] = abs($v);
        } else {
            $parents_in[] = abs($v);
        }
    }

    if (empty($parents_in)) {
        $scriptProperties[\'includeParents\'] = 1;
        $scriptProperties[\'displayStart\'] = 0;
    }
}

if (!empty($displayStart)) {
    $scriptProperties[\'includeParents\'] = 1;
}
if (!empty($ph)) {
    $toPlaceholder = $ph;
}
if (!empty($sortOrder)) {
    $scriptProperties[\'sortdir\'] = $sortOrder;
}
if (!empty($sortBy)) {
    $scriptProperties[\'sortby\'] = $sortBy;
}
if (!empty($permissions)) {
    $scriptProperties[\'checkPermissions\'] = $permissions;
}
if (!empty($cacheResults)) {
    $scriptProperties[\'cache\'] = $cacheResults;
}
if (!empty($ignoreHidden)) {
    $scriptProperties[\'showHidden\'] = $ignoreHidden;
}

$wfTemplates = array(
    \'outerTpl\' => \'tplOuter\',
    \'rowTpl\' => \'tpl\',
    \'parentRowTpl\' => \'tplParentRow\',
    \'parentRowHereTpl\' => \'tplParentRowHere\',
    \'hereTpl\' => \'tplHere\',
    \'innerTpl\' => \'tplInner\',
    \'innerRowTpl\' => \'tplInnerRow\',
    \'innerHereTpl\' => \'tplInnerHere\',
    \'activeParentRowTpl\' => \'tplParentRowActive\',
    \'categoryFoldersTpl\' => \'tplCategoryFolder\',
    \'startItemTpl\' => \'tplStart\',
);
foreach ($wfTemplates as $k => $v) {
    if (isset(${$k})) {
        $scriptProperties[$v] = ${$k};
    }
}
//---

/** @var pdoMenu $pdoMenu */
$fqn = $modx->getOption(\'pdoMenu.class\', null, \'pdotools.pdomenu\', true);
$path = $modx->getOption(\'pdomenu_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
    $pdoMenu = new $pdoClass($modx, $scriptProperties);
} else {
    return false;
}
$pdoMenu->pdoTools->addTime(\'pdoTools loaded\');

$cache = !empty($cache) || (!$modx->user->id && !empty($cacheAnonymous));
if (empty($scriptProperties[\'cache_key\'])) {
    $scriptProperties[\'cache_key\'] = \'pdomenu/\' . sha1(serialize($scriptProperties));
}

$output = \'\';
$tree = array();
if ($cache) {
    $tree = $pdoMenu->pdoTools->getCache($scriptProperties);
}
if (empty($tree)) {
    $data = $pdoMenu->pdoTools->run();
    $data = $pdoMenu->pdoTools->buildTree($data, \'id\', \'parent\', $specified_parents);
    $tree = array();
    foreach ($data as $k => $v) {
        if (empty($v[\'id\'])) {
            if (!in_array($k, $specified_parents) && !$pdoMenu->checkResource($k)) {
                continue;
            } else {
                $tree = array_merge($tree, $v[\'children\']);
            }
        } else {
            $tree[$k] = $v;
        }
    }
    if ($cache) {
        $pdoMenu->pdoTools->setCache($tree, $scriptProperties);
    }
}
if (isset($return) && $return === \'data\') {
    return $tree;
}
if (!empty($tree)) {
    $output = $pdoMenu->templateTree($tree);
}

if ($modx->user->hasSessionContext(\'mgr\') && !empty($showLog)) {
    $output .= \'<pre class="pdoMenuLog">\' . print_r($pdoMenu->pdoTools->getTime(), 1) . \'</pre>\';
}

if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
} else {
    return $output;
}',
          'locked' => false,
          'properties' => 
          array (
            'showLog' => 
            array (
              'name' => 'showLog',
              'desc' => 'pdotools_prop_showLog',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Показывать дополнительную информацию о работе сниппета. Только для авторизованных в контекте "mgr".',
              'area_trans' => '',
            ),
            'fastMode' => 
            array (
              'name' => 'fastMode',
              'desc' => 'pdotools_prop_fastMode',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Быстрый режим обработки чанков. Все необработанные теги (условия, сниппеты и т.п.) будут вырезаны.',
              'area_trans' => '',
            ),
            'level' => 
            array (
              'name' => 'level',
              'desc' => 'pdotools_prop_level',
              'type' => 'numberfield',
              'options' => 
              array (
              ),
              'value' => 0,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Уровень генерируемого меню.',
              'area_trans' => '',
            ),
            'parents' => 
            array (
              'name' => 'parents',
              'desc' => 'pdotools_prop_parents',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Список родителей, через запятую, для поиска результатов. По умолчанию выборка ограничена текущим родителем. Если поставить 0 - выборка не ограничивается. Если id родителя начинается с дефиса, он и его потомки исключается из выборки.',
              'area_trans' => '',
            ),
            'displayStart' => 
            array (
              'name' => 'displayStart',
              'desc' => 'pdotools_prop_displayStart',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Включить показ начальных узлов меню. Полезно при указании более одного "parents".',
              'area_trans' => '',
            ),
            'resources' => 
            array (
              'name' => 'resources',
              'desc' => 'pdotools_prop_resources',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Список ресурсов, через запятую, для вывода в результатах. Если id ресурса начинается с дефиса, этот ресурс исключается из выборки.',
              'area_trans' => '',
            ),
            'templates' => 
            array (
              'name' => 'templates',
              'desc' => 'pdotools_prop_templates',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Список шаблонов, через запятую, для фильтрации результатов. Если id шаблона начинается с дефиса, ресурсы с ним исключается из выборки.',
              'area_trans' => '',
            ),
            'context' => 
            array (
              'name' => 'context',
              'desc' => 'pdotools_prop_context',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Ограничение выборки по контексту ресурсов.',
              'area_trans' => '',
            ),
            'cache' => 
            array (
              'name' => 'cache',
              'desc' => 'pdotools_prop_cache',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Кэширование результатов работы сниппета.',
              'area_trans' => '',
            ),
            'cacheTime' => 
            array (
              'name' => 'cacheTime',
              'desc' => 'pdotools_prop_cacheTime',
              'type' => 'numberfield',
              'options' => 
              array (
              ),
              'value' => 3600,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Время актуальности кэша в секундах.',
              'area_trans' => '',
            ),
            'cacheAnonymous' => 
            array (
              'name' => 'cacheAnonymous',
              'desc' => 'pdotools_prop_cacheAnonymous',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Включить кэширование только для неавторизованных посетителей.',
              'area_trans' => '',
            ),
            'plPrefix' => 
            array (
              'name' => 'plPrefix',
              'desc' => 'pdotools_prop_plPrefix',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => 'wf.',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Префикс для выставляемых плейсхолдеров, по умолчанию "wf.".',
              'area_trans' => '',
            ),
            'showHidden' => 
            array (
              'name' => 'showHidden',
              'desc' => 'pdotools_prop_showHidden',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Показывать ресурсы, скрытые в меню.',
              'area_trans' => '',
            ),
            'showUnpublished' => 
            array (
              'name' => 'showUnpublished',
              'desc' => 'pdotools_prop_showUnpublished',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Показывать неопубликованные ресурсы.',
              'area_trans' => '',
            ),
            'showDeleted' => 
            array (
              'name' => 'showDeleted',
              'desc' => 'pdotools_prop_showDeleted',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Показывать удалённые ресурсы.',
              'area_trans' => '',
            ),
            'previewUnpublished' => 
            array (
              'name' => 'previewUnpublished',
              'desc' => 'pdotools_prop_previewUnpublished',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Включить показ неопубликованных документов, если у пользователя есть на это разрешение.',
              'area_trans' => '',
            ),
            'hideSubMenus' => 
            array (
              'name' => 'hideSubMenus',
              'desc' => 'pdotools_prop_hideSubMenus',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Спрятать неактивные ветки меню.',
              'area_trans' => '',
            ),
            'useWeblinkUrl' => 
            array (
              'name' => 'useWeblinkUrl',
              'desc' => 'pdotools_prop_useWeblinkUrl',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => true,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Генерировать ссылку с учетом класса ресурса.',
              'area_trans' => '',
            ),
            'sortdir' => 
            array (
              'name' => 'sortdir',
              'desc' => 'pdotools_prop_sortdir',
              'type' => 'list',
              'options' => 
              array (
                0 => 
                array (
                  'text' => 'ASC',
                  'value' => 'ASC',
                  'name' => 'ASC',
                ),
                1 => 
                array (
                  'text' => 'DESC',
                  'value' => 'DESC',
                  'name' => 'DESC',
                ),
              ),
              'value' => 'ASC',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Направление сортировки: по убыванию или возрастанию.',
              'area_trans' => '',
            ),
            'sortby' => 
            array (
              'name' => 'sortby',
              'desc' => 'pdotools_prop_sortby',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => 'menuindex',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Любое поле ресурса для сортировки, включая ТВ параметр, если он указан в параметре "includeTVs". Можно указывать JSON строку с массивом нескольких полей. Для случайно сортировки укажите "RAND()"',
              'area_trans' => '',
            ),
            'limit' => 
            array (
              'name' => 'limit',
              'desc' => 'pdotools_prop_limit',
              'type' => 'numberfield',
              'options' => 
              array (
              ),
              'value' => 0,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Ограничение количества результатов выборки. Можно использовать "0".',
              'area_trans' => '',
            ),
            'offset' => 
            array (
              'name' => 'offset',
              'desc' => 'pdotools_prop_offset',
              'type' => 'numberfield',
              'options' => 
              array (
              ),
              'value' => 0,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Пропуск результатов от начала.',
              'area_trans' => '',
            ),
            'rowIdPrefix' => 
            array (
              'name' => 'rowIdPrefix',
              'desc' => 'pdotools_prop_rowIdPrefix',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Префикс id="" для выставления идентификатора в чанк.',
              'area_trans' => '',
            ),
            'firstClass' => 
            array (
              'name' => 'firstClass',
              'desc' => 'pdotools_prop_firstClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => 'first',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс для первого пункта меню.',
              'area_trans' => '',
            ),
            'lastClass' => 
            array (
              'name' => 'lastClass',
              'desc' => 'pdotools_prop_lastClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => 'last',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс последнего пункта меню.',
              'area_trans' => '',
            ),
            'hereClass' => 
            array (
              'name' => 'hereClass',
              'desc' => 'pdotools_prop_hereClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => 'active',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс для активного пункта меню.',
              'area_trans' => '',
            ),
            'parentClass' => 
            array (
              'name' => 'parentClass',
              'desc' => 'pdotools_prop_parentClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс категории меню.',
              'area_trans' => '',
            ),
            'rowClass' => 
            array (
              'name' => 'rowClass',
              'desc' => 'pdotools_prop_rowClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс одной строки меню.',
              'area_trans' => '',
            ),
            'outerClass' => 
            array (
              'name' => 'outerClass',
              'desc' => 'pdotools_prop_outerClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс обертки меню.',
              'area_trans' => '',
            ),
            'innerClass' => 
            array (
              'name' => 'innerClass',
              'desc' => 'pdotools_prop_innerClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс внутренних ссылок меню.',
              'area_trans' => '',
            ),
            'levelClass' => 
            array (
              'name' => 'levelClass',
              'desc' => 'pdotools_prop_levelClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс уровня меню. Например, если укажите "level", то будет "level1", "level2" и т.д.',
              'area_trans' => '',
            ),
            'selfClass' => 
            array (
              'name' => 'selfClass',
              'desc' => 'pdotools_prop_selfClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс текущего документа в меню.',
              'area_trans' => '',
            ),
            'webLinkClass' => 
            array (
              'name' => 'webLinkClass',
              'desc' => 'pdotools_prop_webLinkClass',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Класс документа-ссылки.',
              'area_trans' => '',
            ),
            'tplOuter' => 
            array (
              'name' => 'tplOuter',
              'desc' => 'pdotools_prop_tplOuter',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '@INLINE <ul[[+classes]]>[[+wrapper]]</ul>',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк-обёртка всего блока меню.',
              'area_trans' => '',
            ),
            'tpl' => 
            array (
              'name' => 'tpl',
              'desc' => 'pdotools_prop_tpl',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '@INLINE <li[[+classes]]><a href="[[+link]]" [[+attributes]]>[[+menutitle]]</a>[[+wrapper]]</li>',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Имя чанка для оформления ресурса. Если не указан, то содержимое полей ресурса будет распечатано на экран.',
              'area_trans' => '',
            ),
            'tplParentRow' => 
            array (
              'name' => 'tplParentRow',
              'desc' => 'pdotools_prop_tplParentRow',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления контейнера с потомками.',
              'area_trans' => '',
            ),
            'tplParentRowHere' => 
            array (
              'name' => 'tplParentRowHere',
              'desc' => 'pdotools_prop_tplParentRowHere',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления текущего контейнера с потомками.',
              'area_trans' => '',
            ),
            'tplHere' => 
            array (
              'name' => 'tplHere',
              'desc' => 'pdotools_prop_tplHere',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк текущего документа',
              'area_trans' => '',
            ),
            'tplInner' => 
            array (
              'name' => 'tplInner',
              'desc' => 'pdotools_prop_tplInner',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк-обёртка внутренних пунктов меню. Если пуст - будет использовать "tplOuter".',
              'area_trans' => '',
            ),
            'tplInnerRow' => 
            array (
              'name' => 'tplInnerRow',
              'desc' => 'pdotools_prop_tplInnerRow',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления одного пункта меню.',
              'area_trans' => '',
            ),
            'tplInnerHere' => 
            array (
              'name' => 'tplInnerHere',
              'desc' => 'pdotools_prop_tplInnerHere',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления активного пункта меню.',
              'area_trans' => '',
            ),
            'tplParentRowActive' => 
            array (
              'name' => 'tplParentRowActive',
              'desc' => 'pdotools_prop_tplParentRowActive',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления активного контейнера с потомками.',
              'area_trans' => '',
            ),
            'tplCategoryFolder' => 
            array (
              'name' => 'tplCategoryFolder',
              'desc' => 'pdotools_prop_tplCategoryFolder',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Специальный чанк оформления категории. Категория - это документ с потомками и или нулевым шаблоном, или с атрибутом "rel=\\"category\\"".',
              'area_trans' => '',
            ),
            'tplStart' => 
            array (
              'name' => 'tplStart',
              'desc' => 'pdotools_prop_tplStart',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '@INLINE <h2[[+classes]]>[[+menutitle]]</h2>[[+wrapper]]',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Чанк оформления корневого пункта, при условии, что включен "displayStart".',
              'area_trans' => '',
            ),
            'checkPermissions' => 
            array (
              'name' => 'checkPermissions',
              'desc' => 'pdotools_prop_checkPermissions',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Укажите, какие разрешения нужно проверять у пользователя при выводе документов.',
              'area_trans' => '',
            ),
            'hereId' => 
            array (
              'name' => 'hereId',
              'desc' => 'pdotools_prop_hereId',
              'type' => 'numberfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Id документа, текущего для генерируемого меню. Нужно указывать только если скрипт сам его неверно определяет, например при выводе меню из чанка другого сниппета.',
              'area_trans' => '',
            ),
            'where' => 
            array (
              'name' => 'where',
              'desc' => 'pdotools_prop_where',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Массив дополнительных параметров выборки, закодированный в JSON.',
              'area_trans' => '',
            ),
            'select' => 
            array (
              'name' => 'select',
              'desc' => 'pdotools_prop_select',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Список полей для выборки, через запятую. Можно указывать JSON строку с массивом, например {"modResource":"id,pagetitle,content"}.',
              'area_trans' => '',
            ),
            'scheme' => 
            array (
              'name' => 'scheme',
              'desc' => 'pdotools_prop_scheme',
              'type' => 'list',
              'options' => 
              array (
                0 => 
                array (
                  'value' => '',
                  'text' => 'System default',
                  'name' => 'System default',
                ),
                1 => 
                array (
                  'value' => -1,
                  'text' => '-1 (relative to site_url)',
                  'name' => '-1 (relative to site_url)',
                ),
                2 => 
                array (
                  'value' => 'full',
                  'text' => 'full (absolute, prepended with site_url)',
                  'name' => 'full (absolute, prepended with site_url)',
                ),
                3 => 
                array (
                  'value' => 'abs',
                  'text' => 'abs (absolute, prepended with base_url)',
                  'name' => 'abs (absolute, prepended with base_url)',
                ),
                4 => 
                array (
                  'value' => 'http',
                  'text' => 'http (absolute, forced to http scheme)',
                  'name' => 'http (absolute, forced to http scheme)',
                ),
                5 => 
                array (
                  'value' => 'https',
                  'text' => 'https (absolute, forced to https scheme)',
                  'name' => 'https (absolute, forced to https scheme)',
                ),
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Схема формирования ссылок: "uri" для подстановки поля uri документа (очень быстро) или параметр для modX::makeUrl().',
              'area_trans' => '',
            ),
            'toPlaceholder' => 
            array (
              'name' => 'toPlaceholder',
              'desc' => 'pdotools_prop_toPlaceholder',
              'type' => 'textfield',
              'options' => 
              array (
              ),
              'value' => '',
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Если не пусто, сниппет сохранит все данные в плейсхолдер с этим именем, вместо вывода не экран.',
              'area_trans' => '',
            ),
            'countChildren' => 
            array (
              'name' => 'countChildren',
              'desc' => 'pdotools_prop_countChildren',
              'type' => 'combo-boolean',
              'options' => 
              array (
              ),
              'value' => false,
              'lexicon' => 'pdotools:properties',
              'area' => '',
              'desc_trans' => 'Вывести точное количество активных потомков документа в плейсхолдер [[+children]].',
              'area_trans' => '',
            ),
          ),
          'moduleguid' => '',
          'static' => false,
          'static_file' => 'core/components/pdotools/elements/snippets/snippet.pdomenu.php',
          'content' => '/** @var array $scriptProperties */
/** @var modX $modx */

// Convert parameters from Wayfinder if exists
if (isset($startId)) {
    $scriptProperties[\'parents\'] = $startId;
}
if (!empty($includeDocs)) {
    $tmp = array_map(\'trim\', explode(\',\', $includeDocs));
    foreach ($tmp as $v) {
        if (!empty($scriptProperties[\'resources\'])) {
            $scriptProperties[\'resources\'] .= \',\' . $v;
        } else {
            $scriptProperties[\'resources\'] = $v;
        }
    }
}
if (!empty($excludeDocs)) {
    $tmp = array_map(\'trim\', explode(\',\', $excludeDocs));
    foreach ($tmp as $v) {
        if (!empty($scriptProperties[\'resources\'])) {
            $scriptProperties[\'resources\'] .= \',-\' . $v;
        } else {
            $scriptProperties[\'resources\'] = \'-\' . $v;
        }
    }
}

if (!empty($previewUnpublished) && $modx->hasPermission(\'view_unpublished\')) {
    $scriptProperties[\'showUnpublished\'] = 1;
}

$scriptProperties[\'depth\'] = empty($level) ? 100 : abs($level) - 1;
if (!empty($contexts)) {
    $scriptProperties[\'context\'] = $contexts;
}
if (empty($scriptProperties[\'context\'])) {
    $scriptProperties[\'context\'] = $modx->resource->context_key;
}

// Save original parents specified by user
$specified_parents = array_map(\'trim\', explode(\',\', $scriptProperties[\'parents\']));

if ($scriptProperties[\'parents\'] === \'\') {
    $scriptProperties[\'parents\'] = $modx->resource->id;
} elseif ($scriptProperties[\'parents\'] === 0 || $scriptProperties[\'parents\'] === \'0\') {
    if ($scriptProperties[\'depth\'] !== \'\' && $scriptProperties[\'depth\'] !== 100) {
        $contexts = array_map(\'trim\', explode(\',\', $scriptProperties[\'context\']));
        $parents = array();
        if (!empty($scriptProperties[\'showDeleted\'])) {
            /** @var pdoFetch $pdoFetch */
            $pdoFetch = $modx->getService(\'pdoFetch\');
            foreach ($contexts as $ctx) {
                $parents = array_merge($parents, $pdoFetch->getChildIds(\'modResource\', 0, $scriptProperties[\'depth\'], array(\'context\' => $ctx)));
            }
        } else {
            foreach ($contexts as $ctx) {
                $parents = array_merge($parents, $modx->getChildIds(0, $scriptProperties[\'depth\'], array(\'context\' => $ctx)));
            }
        }
        $scriptProperties[\'parents\'] = !empty($parents) ? implode(\',\', $parents) : \'+0\';
        $scriptProperties[\'depth\'] = 0;
    }
    $scriptProperties[\'includeParents\'] = 1;
    $scriptProperties[\'displayStart\'] = 0;
} else {
    $parents = array_map(\'trim\', explode(\',\', $scriptProperties[\'parents\']));
    $parents_in = $parents_out = array();
    foreach ($parents as $v) {
        if (!is_numeric($v)) {
            continue;
        }
        if ($v[0] == \'-\') {
            $parents_out[] = abs($v);
        } else {
            $parents_in[] = abs($v);
        }
    }

    if (empty($parents_in)) {
        $scriptProperties[\'includeParents\'] = 1;
        $scriptProperties[\'displayStart\'] = 0;
    }
}

if (!empty($displayStart)) {
    $scriptProperties[\'includeParents\'] = 1;
}
if (!empty($ph)) {
    $toPlaceholder = $ph;
}
if (!empty($sortOrder)) {
    $scriptProperties[\'sortdir\'] = $sortOrder;
}
if (!empty($sortBy)) {
    $scriptProperties[\'sortby\'] = $sortBy;
}
if (!empty($permissions)) {
    $scriptProperties[\'checkPermissions\'] = $permissions;
}
if (!empty($cacheResults)) {
    $scriptProperties[\'cache\'] = $cacheResults;
}
if (!empty($ignoreHidden)) {
    $scriptProperties[\'showHidden\'] = $ignoreHidden;
}

$wfTemplates = array(
    \'outerTpl\' => \'tplOuter\',
    \'rowTpl\' => \'tpl\',
    \'parentRowTpl\' => \'tplParentRow\',
    \'parentRowHereTpl\' => \'tplParentRowHere\',
    \'hereTpl\' => \'tplHere\',
    \'innerTpl\' => \'tplInner\',
    \'innerRowTpl\' => \'tplInnerRow\',
    \'innerHereTpl\' => \'tplInnerHere\',
    \'activeParentRowTpl\' => \'tplParentRowActive\',
    \'categoryFoldersTpl\' => \'tplCategoryFolder\',
    \'startItemTpl\' => \'tplStart\',
);
foreach ($wfTemplates as $k => $v) {
    if (isset(${$k})) {
        $scriptProperties[$v] = ${$k};
    }
}
//---

/** @var pdoMenu $pdoMenu */
$fqn = $modx->getOption(\'pdoMenu.class\', null, \'pdotools.pdomenu\', true);
$path = $modx->getOption(\'pdomenu_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
    $pdoMenu = new $pdoClass($modx, $scriptProperties);
} else {
    return false;
}
$pdoMenu->pdoTools->addTime(\'pdoTools loaded\');

$cache = !empty($cache) || (!$modx->user->id && !empty($cacheAnonymous));
if (empty($scriptProperties[\'cache_key\'])) {
    $scriptProperties[\'cache_key\'] = \'pdomenu/\' . sha1(serialize($scriptProperties));
}

$output = \'\';
$tree = array();
if ($cache) {
    $tree = $pdoMenu->pdoTools->getCache($scriptProperties);
}
if (empty($tree)) {
    $data = $pdoMenu->pdoTools->run();
    $data = $pdoMenu->pdoTools->buildTree($data, \'id\', \'parent\', $specified_parents);
    $tree = array();
    foreach ($data as $k => $v) {
        if (empty($v[\'id\'])) {
            if (!in_array($k, $specified_parents) && !$pdoMenu->checkResource($k)) {
                continue;
            } else {
                $tree = array_merge($tree, $v[\'children\']);
            }
        } else {
            $tree[$k] = $v;
        }
    }
    if ($cache) {
        $pdoMenu->pdoTools->setCache($tree, $scriptProperties);
    }
}
if (isset($return) && $return === \'data\') {
    return $tree;
}
if (!empty($tree)) {
    $output = $pdoMenu->templateTree($tree);
}

if ($modx->user->hasSessionContext(\'mgr\') && !empty($showLog)) {
    $output .= \'<pre class="pdoMenuLog">\' . print_r($pdoMenu->pdoTools->getTime(), 1) . \'</pre>\';
}

if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
} else {
    return $output;
}',
        ),
        'policies' => 
        array (
        ),
        'source' => 
        array (
          'id' => 1,
          'name' => 'Filesystem',
          'description' => '',
          'class_key' => 'sources.modFileMediaSource',
          'properties' => 
          array (
          ),
          'is_stream' => true,
        ),
      ),
    ),
    'modTemplateVar' => 
    array (
    ),
  ),
);