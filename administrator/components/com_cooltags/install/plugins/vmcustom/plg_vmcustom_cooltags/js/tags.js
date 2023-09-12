(function($) {
    console.log('1111');
    $(document).ready(function(){
        $(document).on('change', '.vm_tag', function(){
            var tag = new Array();
            $('.vm_tag').each(function(){
                if($(this).val()){
                    tag.push($(this).val());
                }
            });

            $('.vm_tag_full').val(tag.join(','));
        });

        $('.tag_add').click(function(){
            $('.vm_tag_container').append('<div><input class="vm_tag" type="text" size="80" maxlength="255" value=""><span class="vmicon tag_delete"></span></div>');
        });

        $(document).on('click', '.tag_delete', function(){
            var div = $(this).parent();
            div.fadeOut(300, function(){
                div.find('input').val('').change();
                div.remove();
            });
        });
    });

})(jQuery);