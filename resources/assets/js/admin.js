(function($, window, document){

    $('.datetimepicker').each(function(){
        var defaultDate = $(this).val();
        $(this).datetimepicker();
        if (defaultDate !== '') {
            $(this).data('DateTimePicker').defaultDate(moment(defaultDate, 'YYYY-MM-DD HH:mm:ss'));
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#import-videos').on('click', function(){
        var $this = $(this),
            import_url = $this.data('import-url');

        $this.button('loading');

        $.ajax({
            method: 'POST',
            url: import_url,
            success: function() {
                $this.button('reset');
                setTimeout(function(){
                    location.reload();
                }, 1000);
            },
            error: function() {
                $this.button('reset');
            }
        });
    });

    $(".select2").select2();

})(jQuery, window, document);
