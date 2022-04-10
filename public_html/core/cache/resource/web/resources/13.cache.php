<?php  return array (
  'resourceClass' => 'modDocument',
  'resource' => 
  array (
    'id' => 13,
    'type' => 'document',
    'contentType' => 'text/html',
    'pagetitle' => 'widget',
    'longtitle' => '',
    'description' => '',
    'alias' => 'widget',
    'alias_visible' => 1,
    'link_attributes' => '',
    'published' => 1,
    'pub_date' => 0,
    'unpub_date' => 0,
    'parent' => 12,
    'isfolder' => 0,
    'introtext' => '',
    'content' => '<script id="modalBody" type="text/x-jsrender">
    <div class="card">
        <div class="card-body">
            <form class="needs-validation" data-link="{on \'submit\' formData.checkcaptha}">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">ФИО</label> 
                        <input type="text" class="form-control" id="name" data-link="formData.name" required>
                    </div>
                    <div class="col-md-6 mb-3" data-link="visible{:formData.isOp}">
                        <label for="source">Канал поступления</label> 
                        <select class="custom-select d-block w-100" id="source" data-link="{:formData.source:} required{:formData.isOp}">
                            {^{for formData.sourceList}}
                                <option value="{{:id}}"> {{:name}}</option>
                            {{/for}}
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city">Город</label> 
                        <select class="custom-select d-block w-100" id="city" data-link="formData.city" required>
                            {^{for formData.cityList}}
                                <option value="{{:id}}"> {{:name}}</option>
                            {{/for}}
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city">Мед. учреждение</label> 
                        <select class="custom-select d-block w-100" id="city" data-link="formData.medobj" required>
                            {^{for formData.companyList ~selcity=formData.city}}
                                {^{if ~selcity != 0 }}
                                    {^{if id == ~selcity}}
                                        {^{for companyList}}
                                            <option value="{{:id}}"> {{:name}}</option>
                                        {{/for}}
                                    {{/if}}
                                {{else}}
                                    <optgroup label="{{:name}}">
                                        {^{for companyList}}
                                            <option value="{{:id}}"> {{:name}}</option>
                                        {{/for}}
                                    </optgroup>
                                {{/if}}
                            {{/for}}
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="info">Опишите проблему</label> 
                        <textarea id="info" data-link="formData.info" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="custom-file1">
                            <input type="file" class="custom-file-input1" id="files" multiple="" data-link="formData.files"> 
                            <label class="custom-file-label1" for="files">Прикрепить файлы</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {^{radiogroup formData.totype}}
                            <label class="d-block">Как вы хотите получить ответ</label>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input type="radio" class="custom-control-input" name="rdGroup1" value="1" id="rd1"> <label class="custom-control-label" for="rd1">Электронная почта</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input type="radio" class="custom-control-input" name="rdGroup1" value="2" id="rd2"> <label class="custom-control-label" for="rd2">Почтовое отправление</label>
                            </div>
                        {{/radiogroup}}
                    </div>
                </div>
                
                <div class="form-row">
                    {^{if formData.totype == "1"}}
                        <div class="col-md-6 mb-3">
                            <input type="email" class="form-control" data-link="{:formData.email:} required{:formData.totype == \'1\'}" id="email" placeholder="Адрес электронной почты" >
                        </div>
                    {{else formData.totype == "2"}}
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control" data-link="{:formData.zip:} required{:formData.totype == \'2\'}" id="zip" placeholder="Почтовый индекс">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" data-link="{:formData.address:} required{:formData.totype == \'2\'}" id="address" placeholder="Адрес (Населенный пункт, дом, квартира)">
                        </div>
                    {{/if}}
                </div>
                
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Номер телефона</label> 
                        <input type="tel" class="form-control" id="name" data-link="formData.tel" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="ckb1" required> <label class="custom-control-label" for="ckb1">Basic checkbox</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row" data-link="visible{:!formData.capDone}">
                    <div class="col-md-3 mb-3">
                        <img style="width: 100%;" src="http://uroboros.start123.ru/assets/id/images/captcha.png">
                    </div>
                </div>
                
                <div class="form-row" data-link="visible{:!formData.capDone}">
                    <div class="col-md-6 mb-3">
                        <input type="number" class="form-control" id="captha" data-link="formData.captha" placeholder="Введите код с картинки" required>
                    </div>
                </div>
                
                <div class="form-actions" data-link="visible{:!formData.capDone}">
                    <button type="submit" class="btn btn-primary">Продолжить</button>
                </div>
                
                <div class="form-row" data-link="visible{:formData.capDone}">
                    <div class="col-md-12 mb-3">
                        На ваш номер телефона сейчас будет совершен звонок, введите последние 4 цифры
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" class="form-control" id="code" data-link="formData.code">
                    </div>
                    <a class="btn btn-primary col-md-3 mb-3" data-link="{on \'click\' formData.checkcode}">Отправить</a>
                </div>
                
            </form>
        </div>
    </div>
</script>

<script>
var formData = {
    sourceList: [
        {
            id:1,
            name: "Элекронная почта"
        },
        {
            id:2,
            name: "Почтовое отправление"
        }
    ],
    cityList: [
        {
            id:1,
            name: "Краснодар"
        },
        {
            id:2,
            name: "Сочи"
        }
    ],
    companyList: [
        {
            id:1,
            name: "Краснодар",
            companyList: [
                {
                    id:1,
                    name: "Поликлиника 1",
                    city: "Краснодар"
                },
                {
                    id:2,
                    name: "Поликлиника 3",
                    city: "Краснодар"
                },
            ]
        },
        {
            id:2,
            name: "Сочи",
            companyList: [
                {
                    id:3,
                    name: "Поликлиника 1",
                    city: "Сочи"
                },
                {
                    id:4,
                    name: "Поликлиника 2",
                    city: "Сочи"
                }
            ]
        }
    ],
    //isOp: SCRM.app.ugroups.includes("Operator"),
    city: 0,
    totype: "1",
    checkcaptha: function(e,d){
        e.preventDefault();
        $.ajax({
            url: \'/hook/hackaton\',
            method: \'post\',
            data: {
                captcha: formData.captha,
                phone: 79086876923
            },
            success: function(data){
            	if (data == 1) $.observable(formData).setProperty("capDone", true);
            	else alert("Неверный код, попробуйте еще раз");
            }
        });
        
    },
    checkcode: function(e,d){
        e.preventDefault();
        if (formData.code && formData.code.length == 4) {
            $.ajax({
                url: \'/hook/hackaton\',
                method: \'post\',
                data: {
                    action: "confirm",
                    phone: 79086876923,
                    code: formData.code,
                    formData: {
                        "source": formData["source"],
                        "name": formData["name"],
                        "medobj": formData["medobj"],
                        "info": formData["info"],
                        "totype": formData["totype"],
                        "tel": formData["tel"],
                        "email": formData["email"],
                        "zip": formData["zip"],
                        "address": formData["address"]
                    }
                },
                success: function(data){
                	if (data == 1){
                	    SCRM.success("Обращение подано");
                	} else {
                	    alert("Неверный код");
                	}
                }
            });
        } else {
            alert("Неверно заполнен код");
        }
    }
    
};
function openDrawer(){
    var modalVar = {
        title: \'Новое обращение\',
		body: \'#modalBody\',
		formData: formData,
		cm_size: \'lg\'
	};
	club_Drawer(modalVar);
}
</script>

   ',
    'richtext' => 0,
    'template' => 2,
    'menuindex' => 0,
    'searchable' => 0,
    'cacheable' => 1,
    'createdby' => 1,
    'createdon' => 1649584175,
    'editedby' => 1,
    'editedon' => 1649586600,
    'deleted' => 0,
    'deletedon' => 0,
    'deletedby' => 0,
    'publishedon' => 1649584200,
    'publishedby' => 1,
    'menutitle' => '',
    'donthit' => 0,
    'privateweb' => 0,
    'privatemgr' => 0,
    'content_dispo' => 0,
    'hidemenu' => 1,
    'class_key' => 'modDocument',
    'context_key' => 'web',
    'content_type' => 1,
    'uri' => 'projects/widget.html',
    'uri_override' => 0,
    'hide_children_in_tree' => 0,
    'show_in_tree' => 1,
    'properties' => NULL,
    '_content' => '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    
    <title>widget | РосМедНадзор</title>

<link rel="stylesheet" href="/assets/id/wss/theme.min.css?v=1074" />

<script src="/assets/id/wss/jquery.min.js?ver=3.3.1"></script>
<script src="/js/[[!++scrm_prugv]]/start.js" id="start_js"></script>

[[!+StartupHTMLBlock]]
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
</head>
<body id="body13" class="spinner-parent" data-user="[[!+modx.user.id]]" data-mxq="[^q^]">
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
                      <h2 class="card-title" data-link="html^{:title}">widget</h2>
                      <h6 class="card-subtitle text-muted" data-link="html^{:subtitle}"></h6>
                    </div>
                    <div class="nav-scroller" id="topNavTabs" data-link="visible{:topNavTabs^length}">
                        <div class="nav nav-tabs" data-link="{for topNavTabs tmpl=\'#tpl_topNavTab\'}"></div>
                    </div>
                  
                </header>
                <div class="page-inner">
                  
                  
                    <div class="page-section">
<script id="modalBody" type="text/x-jsrender">
    <div class="card">
        <div class="card-body">
            <form class="needs-validation" data-link="{on \'submit\' formData.checkcaptha}">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">ФИО</label> 
                        <input type="text" class="form-control" id="name" data-link="formData.name" required>
                    </div>
                    <div class="col-md-6 mb-3" data-link="visible{:formData.isOp}">
                        <label for="source">Канал поступления</label> 
                        <select class="custom-select d-block w-100" id="source" data-link="{:formData.source:} required{:formData.isOp}">
                            {^{for formData.sourceList}}
                                <option value="{{:id}}"> {{:name}}</option>
                            {{/for}}
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city">Город</label> 
                        <select class="custom-select d-block w-100" id="city" data-link="formData.city" required>
                            {^{for formData.cityList}}
                                <option value="{{:id}}"> {{:name}}</option>
                            {{/for}}
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="city">Мед. учреждение</label> 
                        <select class="custom-select d-block w-100" id="city" data-link="formData.medobj" required>
                            {^{for formData.companyList ~selcity=formData.city}}
                                {^{if ~selcity != 0 }}
                                    {^{if id == ~selcity}}
                                        {^{for companyList}}
                                            <option value="{{:id}}"> {{:name}}</option>
                                        {{/for}}
                                    {{/if}}
                                {{else}}
                                    <optgroup label="{{:name}}">
                                        {^{for companyList}}
                                            <option value="{{:id}}"> {{:name}}</option>
                                        {{/for}}
                                    </optgroup>
                                {{/if}}
                            {{/for}}
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="info">Опишите проблему</label> 
                        <textarea id="info" data-link="formData.info" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="custom-file1">
                            <input type="file" class="custom-file-input1" id="files" multiple="" data-link="formData.files"> 
                            <label class="custom-file-label1" for="files">Прикрепить файлы</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {^{radiogroup formData.totype}}
                            <label class="d-block">Как вы хотите получить ответ</label>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input type="radio" class="custom-control-input" name="rdGroup1" value="1" id="rd1"> <label class="custom-control-label" for="rd1">Электронная почта</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <input type="radio" class="custom-control-input" name="rdGroup1" value="2" id="rd2"> <label class="custom-control-label" for="rd2">Почтовое отправление</label>
                            </div>
                        {{/radiogroup}}
                    </div>
                </div>
                
                <div class="form-row">
                    {^{if formData.totype == "1"}}
                        <div class="col-md-6 mb-3">
                            <input type="email" class="form-control" data-link="{:formData.email:} required{:formData.totype == \'1\'}" id="email" placeholder="Адрес электронной почты" >
                        </div>
                    {{else formData.totype == "2"}}
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control" data-link="{:formData.zip:} required{:formData.totype == \'2\'}" id="zip" placeholder="Почтовый индекс">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" data-link="{:formData.address:} required{:formData.totype == \'2\'}" id="address" placeholder="Адрес (Населенный пункт, дом, квартира)">
                        </div>
                    {{/if}}
                </div>
                
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Номер телефона</label> 
                        <input type="tel" class="form-control" id="name" data-link="formData.tel" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="ckb1" required> <label class="custom-control-label" for="ckb1">Basic checkbox</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row" data-link="visible{:!formData.capDone}">
                    <div class="col-md-3 mb-3">
                        <img style="width: 100%;" src="http://uroboros.start123.ru/assets/id/images/captcha.png">
                    </div>
                </div>
                
                <div class="form-row" data-link="visible{:!formData.capDone}">
                    <div class="col-md-6 mb-3">
                        <input type="number" class="form-control" id="captha" data-link="formData.captha" placeholder="Введите код с картинки" required>
                    </div>
                </div>
                
                <div class="form-actions" data-link="visible{:!formData.capDone}">
                    <button type="submit" class="btn btn-primary">Продолжить</button>
                </div>
                
                <div class="form-row" data-link="visible{:formData.capDone}">
                    <div class="col-md-12 mb-3">
                        На ваш номер телефона сейчас будет совершен звонок, введите последние 4 цифры
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" class="form-control" id="code" data-link="formData.code">
                    </div>
                    <a class="btn btn-primary col-md-3 mb-3" data-link="{on \'click\' formData.checkcode}">Отправить</a>
                </div>
                
            </form>
        </div>
    </div>
</script>

<script>
var formData = {
    sourceList: [
        {
            id:1,
            name: "Элекронная почта"
        },
        {
            id:2,
            name: "Почтовое отправление"
        }
    ],
    cityList: [
        {
            id:1,
            name: "Краснодар"
        },
        {
            id:2,
            name: "Сочи"
        }
    ],
    companyList: [
        {
            id:1,
            name: "Краснодар",
            companyList: [
                {
                    id:1,
                    name: "Поликлиника 1",
                    city: "Краснодар"
                },
                {
                    id:2,
                    name: "Поликлиника 3",
                    city: "Краснодар"
                },
            ]
        },
        {
            id:2,
            name: "Сочи",
            companyList: [
                {
                    id:3,
                    name: "Поликлиника 1",
                    city: "Сочи"
                },
                {
                    id:4,
                    name: "Поликлиника 2",
                    city: "Сочи"
                }
            ]
        }
    ],
    //isOp: SCRM.app.ugroups.includes("Operator"),
    city: 0,
    totype: "1",
    checkcaptha: function(e,d){
        e.preventDefault();
        $.ajax({
            url: \'/hook/hackaton\',
            method: \'post\',
            data: {
                captcha: formData.captha,
                phone: 79086876923
            },
            success: function(data){
            	if (data == 1) $.observable(formData).setProperty("capDone", true);
            	else alert("Неверный код, попробуйте еще раз");
            }
        });
        
    },
    checkcode: function(e,d){
        e.preventDefault();
        if (formData.code && formData.code.length == 4) {
            $.ajax({
                url: \'/hook/hackaton\',
                method: \'post\',
                data: {
                    action: "confirm",
                    phone: 79086876923,
                    code: formData.code,
                    formData: {
                        "source": formData["source"],
                        "name": formData["name"],
                        "medobj": formData["medobj"],
                        "info": formData["info"],
                        "totype": formData["totype"],
                        "tel": formData["tel"],
                        "email": formData["email"],
                        "zip": formData["zip"],
                        "address": formData["address"]
                    }
                },
                success: function(data){
                	if (data == 1){
                	    SCRM.success("Обращение подано");
                	} else {
                	    alert("Неверный код");
                	}
                }
            });
        } else {
            alert("Неверно заполнен код");
        }
    }
    
};
function openDrawer(){
    var modalVar = {
        title: \'Новое обращение\',
		body: \'#modalBody\',
		formData: formData,
		cm_size: \'lg\'
	};
	club_Drawer(modalVar);
}
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
    SCRM.app.title = \'widget\';
    $(\'.start-data-link\').link(true, SCRM.app);
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
  'policyCache' => 
  array (
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
    ),
    'modTemplateVar' => 
    array (
    ),
  ),
);