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
    'isfolder' => 1,
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

SCRM._service[\'/projects/widget\'] = function(){
    var modalVar = {
        title: \'Новое обращение\',
		body: \'#modalBody\',
		formData: formData,
		cm_size: \'lg\'
	};
	club_Drawer(modalVar);
};
</script>

   ',
    'richtext' => 0,
    'template' => 0,
    'menuindex' => 0,
    'searchable' => 0,
    'cacheable' => 1,
    'createdby' => 1,
    'createdon' => 1649584175,
    'editedby' => 1,
    'editedon' => 1649589922,
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
    'uri' => 'projects/widget/',
    'uri_override' => 0,
    'hide_children_in_tree' => 0,
    'show_in_tree' => 1,
    'properties' => NULL,
    '_content' => '<script id="modalBody" type="text/x-jsrender">
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

SCRM._service[\'/projects/widget\'] = function(){
    var modalVar = {
        title: \'Новое обращение\',
		body: \'#modalBody\',
		formData: formData,
		cm_size: \'lg\'
	};
	club_Drawer(modalVar);
};
</script>

   ',
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
  'sourceCache' => 
  array (
    'modChunk' => 
    array (
    ),
    'modSnippet' => 
    array (
    ),
    'modTemplateVar' => 
    array (
    ),
  ),
);