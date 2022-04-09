$(document)
.one('jqGridBeforeInit', function(e, grOpts) {
    switch (grOpts.gridEntity) {
        case 'idSportsmen':
        case 'idLead':
        case 'idChanges':
        case 'idOrderItems':
        case 'idShopItem':
        case 'idSchedule':
            $.extend(grOpts.navOpts, {del:true});
    }
    
})
.one('jqGridAfterInit', function(e, grOpts) {
    if (grOpts.gridEntity=='idInvoice')
        $(e.target).jqGrid('setColProp', 'lesson_amount', {hidedlg: false});
        
    switch (grOpts.gridEntity) {
        case 'idSportsmen':
        case 'idLead':
            $(e.target).jqGrid('setColProp', 'key', {editable: true});
    }
});

$(function(){
    $('#chCity').attr('data-run', '/chunk/user.city');
});
