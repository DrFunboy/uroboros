$(function() {
    $('#mmenuModal')
    .on('show.bs.modal', function(e){
        window.mmparent = $('#main-menu').parent();
        $('#main-menu').appendTo( $(this).find('.modal-body') );
    })
    .on('hide.bs.modal', function(e){
        $('#main-menu').appendTo( mmparent );
    });
    
    $('#left-menu ul li.active').closest('.collapse').collapse('show');
});
window.addEventListener('message', function(e) {
    if (e.data && e.data.scrm_iname) {
        $('[name="'+e.data.scrm_iname+'"]').css({
            height: e.data.i_h+'px'
        });
    }
});