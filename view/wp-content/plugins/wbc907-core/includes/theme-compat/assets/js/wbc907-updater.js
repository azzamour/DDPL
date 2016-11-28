(function($){

	$('.wbc907-update-notice .wbc907-run-update').click(function(event){
		event.preventDefault();
		
		var r = confirm('Are you sure you want to run updater?');

        if (r == false) return;

        var el = $(this),
        wbc_updater = true;

        var data = {};

        data.action = "wbc907_update";
        data.nounce = el.attr("data-nounce");
        data.wbc_update_action = 'update';
        // $('.wbc907-update-notice').hide();
        $('.wbc907-updating-notice').show();
        $.post(ajaxurl, data, function(response) {
        	wbc_show_progress( data );
        	wbc_updater = false;
        });

		setTimeout(function(){
            wbc_show_progress(data);
        },500);

        function wbc_show_progress( data ){
            if(wbc_updater == false) return;
            data.wbc_update_action = 'message';
                
                jQuery.ajax({
                    url: ajaxurl,
                    data: data,
                    success:function(response){
                        if (response.length > 0){
                        	$('.wbc907-updating-notice').html(response);
                            setTimeout(function(){
                                wbc_show_progress(data);
                            },10);
                        }
                    }
                });
        }

	});

    //Skip Update
    $('.wbc907-update-notice .wbc907-skip-update').click(function(event){
        event.preventDefault();
        
        var r = confirm('Are you sure you want to skip update?');

        if (r == false) return;

        var el = $(this),
        wbc_updater = true;

        var data = {};

        data.action = "wbc907_update";
        data.nounce = el.attr("data-nounce");
        data.wbc_update_action = 'skip-update';

        $.post(ajaxurl, data, function(response) {
            $('.wbc907-update-notice').hide();
            setTimeout(function(){
                location.reload(true);
            },200);
            
        });

    });
})(jQuery);