/**
 * @license jqGrid Russian Translation v1.0 02.07.2009 based on translation by Alexey Kanaev, v1.1 21.01.2009 (http://softcore.com.ru) and 07.01.2015 (http://smartcore.ru)
**/

var jqGridDict = {
	isRTL: false,
	defaults: {
		recordtext: "{0} - {1} из {2}",
		emptyrecords: "Нет записей для просмотра",
		loadtext: "Загрузка...",
		pgtext: "Стр. {0} из {1}",
		pgfirst: "Первая стр.",
		pglast: "Последняя стр.",
		pgnext: "След. стр.",
		pgprev: "Пред. стр.",
		pgrecs: "Записей на стр.",
		showhide: "Показать/скрыть таблицу",
		savetext: "Сохранение..."
	},
	search: {
		caption: "Поиск...",
		Find: "Найти",
		Reset: "Сброс",
		odata: [
			{ oper: "eq", text: "равно" },
			{ oper: "ne", text: "не равно" },
			{ oper: "lt", text: "меньше" },
			{ oper: "le", text: "меньше или равно" },
			{ oper: "gt", text: "больше" },
			{ oper: "ge", text: "больше или равно" },
			{ oper: "bw", text: "начинается с" },
			{ oper: "bn", text: "не начинается с" },
			{ oper: "in", text: "находится в" },
			{ oper: "ni", text: "не находится в" },
			{ oper: "ew", text: "заканчивается на" },
			{ oper: "en", text: "не заканчивается на" },
			{ oper: "cn", text: "содержит" },
			{ oper: "nc", text: "не содержит" },
			{ oper: "nu", text: "равно NULL" },
			{ oper: "nn", text: "не равно NULL" }
		],
		groupOps: [
			{ op: "AND", text: "все" },
			{ op: "OR", text: "любой" }
		],
		addGroupTitle: "Добавить группу",
		deleteGroupTitle: "Удалить группу",
		addRuleTitle: "Добавить правило",
		deleteRuleTitle: "Удалить правило",
		operandTitle: "Выбрать операцию поиска",
		resetTitle: "Сбросить"
	},
	edit: {
		addCaption: "Добавить запись",
		editCaption: "Редактировать запись",
		bSubmit: "Сохранить",
		bCancel: "Отмена",
		bClose: "Закрыть",
		saveData: "Данные были измененны! Сохранить изменения?",
		bYes: "Да",
		bNo: "Нет",
		bExit: "Отмена",
		msg: {
			required: "Поле является обязательным",
			number: "Пожалуйста, введите правильное число",
			minValue: "значение должно быть больше либо равно",
			maxValue: "значение должно быть меньше либо равно",
			email: "некорректное значение e-mail",
			integer: "Пожалуйста, введите целое число",
			date: "Пожалуйста, введите правильную дату",
			url: "неверная ссылка. Необходимо ввести префикс ('http://' или 'https://')",
			nodefined: " не определено!",
			novalue: " возвращаемое значение обязательно!",
			customarray: "Пользовательская функция должна возвращать массив!",
			customfcheck: "Пользовательская функция должна присутствовать в случаи пользовательской проверки!"
		}
	},
	view: {
		caption: "Просмотр записи",
		bClose: "Закрыть"
	},
	del: {
		caption: "Удалить",
		msg: "Удалить выбранную запись(и)?",
		bSubmit: "Удалить",
		bCancel: "Отмена"
	},
	nav: {
		edittext: "",
		edittitle: "Редактировать выбранную запись",
		addtext: "",
		addtitle: "Добавить новую запись",
		deltext: "",
		deltitle: "Удалить выбранную запись",
		searchtext: "",
		searchtitle: "Найти записи",
		refreshtext: "",
		refreshtitle: "Обновить таблицу",
		alertcap: "Внимание",
		alerttext: "Пожалуйста, выберите запись",
		viewtext: "",
		viewtitle: "Просмотреть выбранную запись",
		savetext: "",
		savetitle: "Сохранить запись",
		canceltext: "",
		canceltitle: "Отмена изменений"
	},
	col: {
		caption: "Показать/скрыть столбцы",
		bSubmit: "Сохранить",
		bCancel: "Отмена"
	},
	errors: {
		errcap: "Ошибка",
		nourl: "URL не установлен",
		norecords: "Нет записей для обработки",
		model: "Число полей не соответствует числу столбцов таблицы!"
	},
	formatter: {
		integer: { thousandsSeparator: " ", defaultValue: "0" },
		number: { decimalSeparator: ",", thousandsSeparator: " ", decimalPlaces: 2, defaultValue: "0,00" },
		currency: { decimalSeparator: ",", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix: "", defaultValue: "0,00" },
		date: {
			dayNames: [
				"Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб",
				"Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"
			],
			monthNames: [
				"Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек",
				"Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
			],
			AmPm: ["am", "pm", "AM", "PM"],
			S: function () { return ""; },
			srcformat: "Y-m-d",
			newformat: "d.m.Y",
			masks: {
				ShortDate: "n.j.Y",
				LongDate: "l, F d, Y",
				FullDateTime: "l, F d, Y G:i:s",
				MonthDay: "F d",
				ShortTime: "G:i",
				LongTime: "G:i:s",
				YearMonth: "F, Y"
			}
		}
	}
};
$.extend(true, $.jgrid, {
	defaults: {
		locale: "ru"
	},
	locales: {
		// In general the property name is free, but it's recommended to use the names based on
		// http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry
		// http://rishida.net/utils/subtags/ and RFC 5646. See Appendix A of RFC 5646 for examples.
		// One can use the lang attribute to specify language tags in HTML, and the xml:lang attribute for XML
		// if it exists. See http://www.w3.org/International/articles/language-tags/#extlang
		ru: jqGridDict
		//"ru-RU": $.extend({}, locInfo, { name: "русский (Россия)", nameEnglish: "Russian (Russia)" })
	}
});

/* jqGrid */
$.extend(true, $.jgrid.cmTemplate.booleanCheckboxFa, {
    width: 30,
    editoptions: {value: '1:0'},
    searchoptions: {value: '1:0'}
});

var lookAll = ":*",
    grids = {},
    cls = {
        err: ' class="rowNo"',
        err2: ' class="rowNo2"',
        warn: ' class="rowWarn"',
        yes: ' class="rowYes"',
        arc: ' class="rowArc"'
    },
    numberSearchOptions = ['eq', 'ne', 'lt', 'le', 'gt', 'ge', 'nu', 'nn', 'in', 'ni'],
    idFieldTemplate = {
		name:'id', width: 65, hidden: true,
		align: 'right', sorttype: 'int',
		searchrules: { integer: true },
		searchoptions: {
			dataInit: function (element) {
                var fltrTable = $(element).closest('table');
                if ( fltrTable.hasClass('ui-search-table') ) {
                    $('td.ui-search-oper', fltrTable).hide();
                }
            },
            sopt: numberSearchOptions
        }
    },
    numberFormatter = function (cellValue, options, rowObject) {
        return (cellValue && cellValue*1 !== 0)? cellValue : '';
    },
    editRowLinkFmt = function(cv, opts, data) {
        var erld = opts.colModel.editRowLinkData;
        var add = erld ? ' data-value="'+ data[ erld===true? opts.colModel.name : erld ] +'"' : '';
        return '<a href="#" class="editGridRowLink" data-id="'+ opts.rowId +'"'+add+'>'+ cv +'</a>';
    },
    editRowLinkUnfmt = function(cellValue, opts, cell) {
        return opts.colModel.editRowLinkData? $('a', cell).data('value') : $.trim( $(cell).text() );
    },
    editRowLinkTemplate = {
        formatter: editRowLinkFmt,
        unformat: editRowLinkUnfmt
    },
    numberTemplate = {
        width:75,
        formatter: numberFormatter,
        align: 'right', sorttype: 'number',
        searchoptions: { sopt: numberSearchOptions },
        searchrules: { integer: true },
        editrules: { number: true },
        unformat: function(cellvalue, options, rowObject){
            if (!cellvalue) return 0;
            return cellvalue;
        }
    },
    dateSearchOpts = {
        sopt: ['db'], //["eq","ne","lt","le","gt","ge"]
        dataInit: function (element) {
            var self = this; // save the reference to the grid
            SCRM.loadWSS('flatpickr', function(){
                flatpickr(element, {
                    mode:'range',
                    locale: { rangeSeparator: ';' },
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length==2) setTimeout(function () {
                            self.triggerToolbar();
                        }, 10);
                    }
                });
            });
        }
    },
    dateTemplate = {
        width:85,
        sorttype: 'date', formatter: 'date',
        formatoptions: {srcformat: 'Y-m-d', newformat: 'd.m.Y'},
        editoptions: {
            dataInit: function(element, data) {
                var el = $(element);
                el.on('onInitDateEdit', function(){
                    el.initMaskEdit('00.00.0000');
                })
                .initDateEdit();
            }
        },
        searchoptions: dateSearchOpts,
        searchrules: {date: true}
    },
    dateTimeTemplate = {
        width:110, 
        sorttype:'date', formatter: 'date',
        formatoptions: { srcformat: 'ISO8601Long', newformat: 'd.m.Y H:i' },
        editoptions: {
            dataInit:function(element, data){
                $(element)
                .initDateEdit({
                    disableMobile: true,
                    enableTime: true,
                    dateFormat: 'd.m.Y H:i',
                    clearButton: data.cm.clearButton
                });
            }
        },
        searchoptions: dateSearchOpts,
        searchrules: {date:true}
    },
    menuindexTemplate = {
        name:'menuindex', label:'Сорт.', width:45, sorttype:'int',
        editable: true,
        editoptions: {defaultValue: 10}
    },
    publishedTemplate = $.extend(true, {
        name:'published',
        label:'Опубликован'
    }, $.jgrid.cmTemplate.booleanCheckboxFa, {
        editable: true,
        editoptions: {defaultValue: '1'}
    }),
    fmtCreated = function(cellValue, options, rowObject) {
        if (!options.colModel._tbl) options.colModel._tbl = $(this).jqGrid('getGridParam', 'gridEntity');
        var ed = (rowObject.edited)? makeIco('fa-pencil ml-1') : '';
        return '<a href="#" class="fmtCreated" data-id="'+
            rowObject.id +'" data-tbl="'+ options.colModel._tbl +'">'+ str2date(cellValue, 'dt')+ ed +'</a>';
    },
    createdTemplate = $.extend({
        hidden: true,
        name: 'created',
    }, dateTimeTemplate, {formatter: fmtCreated, width: 125}),
    stringTemplate = {
        searchoptions:{
            sopt:['cn','eq','bw','bn','ew','en']
        }
    },
    lookTemplate = {
        width:80,
        edittype:'select',
        stype: 'select',
        searchoptions: {value: lookAll}
    },
    selTemplate = $.extend({
        formatter:'select',
        editrules: {edithidden:true}
    }, lookTemplate),
    infoTemplate = {
        name:'info', label:'Заметки',
        width:200,
        edittype:'textarea',
        editoptions:{style:'height:4em'},
        cellattr: function (rowId, tv, rawObject, cm, rdata) { 
            return 'style="white-space: pre-wrap"';
        }
    },
    telTemplate = {
        name:'tel', label: 'Телефон',
        width:110,
        formatter: function(cv, opt, data){
            return '<a href="#" class="telPopover" data-id="'+ cv +'">'+ cv +'</a>';
        },
        unformat: editRowLinkUnfmt
    },
    myColumnStateName = function (grid) {
        return window.location.pathname + '#' + grid[0].id+'_ver_1.0';
    },
    makeGridOpts = function(rows, params) {
        params = $.extend({
            id: 'id',
            name: 'name',
            add_all: false
        }, (typeof params === 'boolean')? {add_all:params} : params);
        rows = $.map(rows, function(v, k){
            return v[params.id]+ ':' +v[params.name];
        });
        if (params.add_all) rows.unshift(lookAll);
        return rows.join(';');
    },
    makeSelArray = function(str){
        return $.map(str.split(';'), function(v,i){
            return v+':'+v;
        }).join(';');
    },
    arr2clstring = function(array){
        return (!array || array.length === 0)? '' : ' class="'+array.join(' ')+'"';
    },
    cellInsuranceColor = function(rowId, cellValue, rawObject, cm, rdata) {
        var cls = SCRM._service.dateDiffClass(cellValue, cm.dateDiffWarn, cm.dateDiffDanger);
        if (cls) return arr2clstring(['font-weight-bold', cls]);
    },
    cellEmptyColor = function(rowId, cellValue, rawObject, cm, rdata){
        if (!cellValue) return arr2clstring(['rowNo']);
    },
    getGridSelRows = function(grid, callback) {
        var selIDs = [ ];
        if (grid.jqGrid('getGridParam','multiselect')) {
            selIDs = grid.jqGrid('getGridParam','selarrrow');
        } else {
            var selID = grid.jqGrid('getGridParam','selrow');
            if (selID) selIDs.push(selID);
        }
        if (callback) {
            if (selIDs.length === 0) SCRM.alert(jqGridDict.nav.alerttext); else callback(selIDs);
        }
        return selIDs;
    },
    setFilterValue = function(grid, fld, value) {
        var ev = jQuery.Event("keypress");
        ev.keyCode = 13;
        grid.closest('.ui-jqgrid-view').find('.ui-search-toolbar input[name="'+fld+'"]')
        .val(value).trigger(ev);
    },
    dbvalues0 = function(array, v0) {
        return $.merge([{id: v0, name: SCRM.emptyStr}], array);
    },
    hasPhoto = function(cellValue, options, rowObject) {
        return (cellValue && cellValue!='0')? makeIco('fa-camera', { big: 1 }) : '';
    },
    hasUser = function(cellValue, options, rowObject) {
        return (cellValue)? makeIco('fa-key', { big: 1 }) : '';
    },
    jqGridStartSM = $(window).width() <= 640,
    grid_rows = (SCRM.grid_rows || '15,25,50,100,500,1000,5000').split(','),
    jqg_center = function(form){
        var jqdialog = form.closest('div.ui-jqdialog');
        var t = ( $(window).height() - jqdialog.height() ) / 2+$(window).scrollTop();
        var l = ( $(window).width() - jqdialog.width() ) / 2+$(window).scrollLeft();
        if (t<20) t=20; if (l<10) l=10;
        jqdialog.css({
            position:'absolute',
            left: l + 'px',
            top: t + 'px'
        });
    };
$.extend($.jgrid.defaults, {
    loadui: 'block',
    datatype: 'json', mtype: 'POST',
    height: 'auto',
    width: 700,
    autowidth: true,
    shrinkToFit : false,
    //forceFit : false,
    pager: true,
    rowNum: grid_rows[0],
    rowList: (!jqGridStartSM)? grid_rows : [ ],
    pginput: !jqGridStartSM,
    //altRows:true,
    viewrecords: true, //Defines whether we want to display the number of total records from the query in the pager bar.
    multiboxonly: true, multiPageSelection: true,
    sortable: true,
    jsonReader: {
        repeatitems: false,
        id: 'id'
    },
    iconSet: 'fontAwesome',
    //iconSet: "fontAwesomeSVG",
    guiStyle: 'bootstrap4',
    threeStateSort: true,
    sortIconsBeforeText: true
});

$.extend($.jgrid.nav, {refresh: false});

$.extend($.jgrid.search, {
    autosearch: true,
    stringResult: true,
    searchOperators: true,
    defaultSearch: 'cn',
    operands: {'db':'='}, // date between filter
    width: 550
});


$.extend($.jgrid.edit, {
    recreateForm: true,
    zIndex: 1045, width: 550,
    closeAfterEdit:true, closeAfterAdd:true, viewPagerButtons:false,
    afterShowForm: jqg_center,
    onClose: function(el_id, data) {
        // jqGridAddEditAfterShowForm
        $(el_id+' .removeOnClose-flatpickr').destroyDateEdit();
    }
});
$.extend($.jgrid.del, {
    zIndex: 1045, width:300,
    afterShowForm: jqg_center
});

$.extend(true, $.jgrid.guiStyles.bootstrap4, {
    gView: '',
    hTable: 'table',
    filterToolbar: {
		dataField: 'form-control form-control-sm'
	},
    dialog: {
        footer: 'modal-footer border-top',
        dataField: 'form-control form-control-sm',
        fmButton: 'btn btn-secondary btn-sm px-2 py-1',
    },
    pager: {
		pager: ''
    },
    states: {
		select: 'table-highlight',
		error: 'text-danger'
    }
});

(function ( $ ) {
    $.fn.resize_gr = function(){
		return this.each(function(i, gr){
            var grid = $(gr), ui = grid.closest('.ui-jqgrid');
            var w = ui.parent().width() - 2; // Fudge factor to prevent horizontal scrollbars
            if (w > 0 && Math.abs(w - ui.width()) > 3) {
                //console.log('setGridWidth', w)
                grid.jqGrid('setGridWidth', w);
            }
        });
	};
	
	$.fn.jqGridSetLookup = function(rows, f){
        var gr = this;
        if (typeof f === "string") f = gr.jqGrid('getColProp', f);
        rows = $.map(rows, function(v, i){
            return $.extend({}, v, {
                id: v[f.lookupKey||'id']
            });
        });
        gr.trigger('jqGridBeforeSetLookup', {rows: rows, f: f});
        var editoptions = rows, searchoptions = rows;
        if ('dbvalues0' in f) {
            editoptions = dbvalues0(rows, f.dbvalues0);
            searchoptions = dbvalues0(rows, (f.dbvalues0==='')? '*' : f.dbvalues0);
        }

        var colProp = {
            editoptions: {
                value: makeGridOpts(editoptions) || []
            },
            searchoptions: {
                value: makeGridOpts(searchoptions, {add_all: true})
            },
            dbvaluesLoaded: true
        };
        gr.jqGrid('setColProp', f.name, colProp);
        return gr;
	};

	$.fn.jqGridFilterToolbar = function() {
        if (this[0].ftoolbar) {
            this.jqGrid('destroyFilterToolbar').data('make_ftoolbar', true);
        }
        if (this.data('make_ftoolbar')) this.jqGrid('filterToolbar');
	    return this;
	};

	$.fn.jqGridInit = function(mainOpts) {
        $.extend(mainOpts.navOpts, {});
        var gr = this;
        
        var gEntity = gr.data('entity');
        if (!mainOpts.gridEntity && gEntity) mainOpts.gridEntity = gEntity;
        if (mainOpts.gridEntity) {
            if (!gEntity) gr.attr('data-entity', mainOpts.gridEntity);
            if (!mainOpts.url) mainOpts.url = SCRM.dataUrl + '?table=' + mainOpts.gridEntity;
            if (!mainOpts.editurl) mainOpts.editurl = SCRM.editUrl + '?table=' + mainOpts.gridEntity;
        }

		gr
		//.on('jqGridSelectFilled', function(e, d) { console.log(e, d); })
		.on('jqGridAfterLoadComplete', function(e, data) {
            var  gr = $(this).resize_gr();
            if (data && data.sql && window.console) {
                console.log( data.sql );
            }
		})
		.on('jqGridSerializeGridData', function(e, postData) {
            var postAdd = [],
            colModel = gr.jqGrid('getGridParam','colModel'),
            dbv = $.map(colModel, function(v, i) {
                if (v.dbvalues && !v.dbvaluesLoaded) {
                    if (typeof v.dbvalues === 'string') postAdd.push(v.dbvalues);
                    return v;
                }
            }),
            clubStatus = $.map(colModel, function(f, i) {
                if (f.searchoptions && f.searchoptions.defaultValue) { // Фильтр по умолчанию
                    var fltr = {};
                    fltr[f.name] = f.searchoptions.defaultValue;
                    postData.filters = SCRM.obj2Filter(fltr, postData.filters);
                    delete f.searchoptions.defaultValue;
                }
                return f.clubStatus || null;
            });
            if (dbv.length || clubStatus.length) {
                gr.one('jqGridBeforeProcessing', function(e, data){
                    //console.log('grid_jqGridBeforeProcessing', data);
                    if (postAdd.length) delete postData.dbvalues;
                    if (clubStatus.length) delete postData.clubStatus;
                    
                    if (dbv.length) {
                        $.each(dbv, function(n, f) {
                            if (typeof f.dbvalues === 'string') {
                                if (data.dbvalues && (f.dbvalues in data.dbvalues))
                                    gr.jqGridSetLookup(data.dbvalues[f.dbvalues], f);
                            } else {
                                gr.jqGridSetLookup(f.dbvalues, f);
                            }
                        });
                    }
                    
                    if (data.clubStatus) {
                        SCRM.setClubStatus(data.clubStatus);
                        $.each(colModel, function(n, f) {
                            var scs = SCRM.clubStatus[f.clubStatus];
                            if (scs) {
                                gr.jqGridSetLookup(scs, f);
                                delete f.clubStatus;
                            }
                        });
                    }
                    
                    gr.jqGridFilterToolbar(); //Когда придут новые данные перестроить Lookup
                });

                if (postAdd.length) postData.dbvalues = unique_ar(postAdd).join(',');
                if (clubStatus.length) postData.clubStatus = clubStatus;
            }
		})
		.trigger('jqGridBeforeInit', mainOpts)

		var fbp = mainOpts.beforeProcessing;
		mainOpts.beforeProcessing = function(data, textStatus, jqXHR){
            if ($.isFunction(fbp)) fbp.call(this, data, textStatus, jqXHR);
            gr.triggerHandler('jqGridBeforeProcessing', data, textStatus, jqXHR);
		};

		return gr.jqGrid(mainOpts)
		.jqGrid('navGrid', mainOpts.navOpts)
		.jqGrid('navButtonAdd', {
            caption:'',
            buttonicon: 'fa-refresh',
            title: 'Обновить',
            //position: 'first',
            onClickButton: function() {
                gr.trigger('reloadGrid', [{current:true}]);
            }
        })
        .on('clearSelection', function(e, id){
            var gr = $(this);
            p = gr.jqGrid('resetSelection').jqGrid('getGridParam');
            p.selarrrow = [];
            if (!id) {
                gr.trigger('jqGridSelectAll', [ [], false ]);
            } else {
                gr.jqGrid('setSelection', id);
            }
        })
        .one('jqGridAfterInit', function(){
            if (jqGridStartSM) {
                var c = gr.closest('.ui-jqgrid').find('.ui-jqgrid-pager td.ui-jqgrid-pg-center');
                console.log(c);
                $('table', c).prependTo( c.next() ).css({
                    'margin-right': 0,
                    'margin-bottom': '3px',
                });
                c.remove();
            }
        })
        .trigger('jqGridAfterInit', mainOpts);
	};
	$.fn.jqGridColumns = function(){
		return this.jqGrid('navButtonAdd', {
			caption: '',
			buttonicon: 'fa-table',
			title: 'Выбрать колонки',
			onClickButton: function () {
			    var grid = $(this);
			    SCRM.loadWSS(['multiselect'], function() {
				    grid.jqGrid('columnChooser');
			    });
			}
		});
	};
	$.fn.jqGridExport = function(){
		return this.jqGrid('navButtonAdd', {
            caption:'',
            buttonicon: 'fa-file-excel-o',
            title: 'Экспорт в Excel',
            //position: 'first',
            onClickButton: function() {
                var grid = $(this);
                var colModel = grid.jqGrid('getGridParam', 'colModel');
                
                var cols = [ ], labels = [ ];
                $.each(colModel, function(i, col){
                    if (col.labelClasses && (col.labelClasses=='jqgh_rn' || col.labelClasses=='jqgh_cbox')){
                        return true;
                    }
                    if (!col.hidden){
                        cols.push( col.name );
                        labels.push( (col.label)? col.label : col.name );
                    }
                });
                var pd = {rows: 1001};
                var sel_rows = getGridSelRows(grid);
                if (sel_rows.length>0) pd._where = {id: sel_rows};
                
                pd = $.extend({
                    _export: 'dataRows',
                    excols: cols.join(';'),
                    exlabels: labels.join(';')
                }, grid.jqGrid('getGridParam', 'postData'), pd);
                if (pd._where) pd._where = JSON.stringify(pd._where);
                clubPostForm(grid.jqGrid('getGridParam', 'url'), pd);
            }
        });
	};
	$.fn.setGridFilter = function(fld, value, oper) {
        var grid = this,
            pd = grid.jqGrid('getGridParam', 'postData'),
            setFilters = pd.filters,
            fltrs = (typeof fld === 'string')? [{
                fld: fld, value: value, oper: oper, 
            }] : fld;

	    $.each(fltrs, function(i, fltr) {
            var col = grid.jqGrid('getColProp', fltr.fld);
            //console.log(fltr, col)
            if (col.index) fltr.fld = col.index;
            fltr.oper = fltr.oper || ((col.searchoptions||{}).sopt||[ ])[0] || $.jgrid.search.defaultSearch;
            setFilters = buildFilter(fltr.fld, fltr.value, fltr.oper, setFilters);

            // setFilterValue(grid, fld, value);
	    });
	    //console.log(pd, setFilters)
        return grid.jqGrid('setGridParam', {
            postData: {
                filters: setFilters
            },
            search: true
        }).trigger('reloadGrid', [{page: 1}]);
    };
}( jQuery ));

$(function(){
    $(window).on('resize', function() {
        $('table.ui-jqgrid-btable').resize_gr();
    });
    $(document)
    .on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        $('table.ui-jqgrid-btable', $(e.target).attr('href') ).resize_gr();
    })
    .on('click', '.editGridRowLink', function (e) {
        e.preventDefault();
        var lnk = $(this),
            gr = lnk.closest('table.ui-jqgrid-btable'),
            selId = lnk.data('id');
        gr
        .jqGrid('setSelection', selId)
        .jqGrid('editGridRow', selId);
    });
});
