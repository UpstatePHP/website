(function($, window, document){

    $(document).ready(function(){
        $('.datetimepicker.beginning').datetimepicker({
            format:'m/d/Y g:ia',
            formatTime: 'g:ia',
            onShow:function(ct){
                this.setOptions({
                    maxDate: $('.datetimepicker.ending').val() ? $('.datetimepicker.ending').val() : false
                })
            }
        });
        $('.datetimepicker.ending').datetimepicker({
            format:'m/d/Y g:ia',
            formatTime: 'g:ia',
            onShow:function(ct){
                this.setOptions({
                    minDate: $('.datetimepicker.beginning').val() ? $('.datetimepicker.beginning').val() : false
                })
            }
        });
    });

})(jQuery, window, document);