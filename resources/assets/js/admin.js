(function($, window, document){

    $('.datetimepicker').each(function(){
        var defaultDate = $(this).val();
        $(this).datetimepicker();
        if (defaultDate !== '') {
            $(this).data('DateTimePicker').defaultDate(moment(defaultDate, 'YYYY-MM-DD HH:mm:ss'));
        }
    });

})(jQuery, window, document);