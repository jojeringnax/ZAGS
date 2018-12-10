$(document).ready(function(){
    let toggle = false;
    $('.btn-filter').click( function() {
        if (toggle == false) {
            toggle = true;
            $('.filters').removeClass('hide');
            $('.filters').animate({'opacity': 1});
        } else {
            toggle = false;
            $('.filters').animate({'opacity': 0}, function(){
                $(this).addClass('hide');
            });
        }
    });

    $('.page-link').click( function(e) {
        e.preventDefault();
        let data = $(this).attr('data-page');

        let link = 'http://zags.zu/web/index_cop_old.php?r=admin/games&page=' + data;
        // console.log(link);

        $.ajax({
            url: "?r=admin/games",
            type: 'GET',
            data: {'link':link},
            success: function (data) {
                // alert("Your email has been sent!");
            },
            error: function(jqXHR, exception, response) {
                console.log(jqXHR, exception, response);
            }

        });
    });

    $("#game > .btn-go > #go-game").click( function() {
        let id_inp = $('#search-game').val();
        let date_inp_first = $('#date_first').val();

        date_inp_first = date_inp_first.substr(-4)+'-'+date_inp_first.substr(3,2)+'-'+date_inp_first.substr(0,2);
        // console.log(date_inp_first);

        let date_inp_second = $('#date_second').val();
        date_inp_second = date_inp_second.substr(-4)+'-'+date_inp_second.substr(3,2)+'-'+date_inp_second.substr(0,2);
        // console.log(date_inp_second);

        if(date_inp_first == '') {
            date_inp_first = '1970-02-12';
        } else if (date_inp_second == '') {
            date_inp_second = '2670-02-12';
        } else if (date_inp_second == date_inp_first) {
            date_inp_second += ' 23:59:59';
            date_inp_first += ' 00:00:00';
        }
        let obj_data = {
            'id': id_inp,
            'date_first':date_inp_first,
            'date_second': date_inp_second,
            'link': link
        };


        // console.log(obj_data);
        $.ajax({
            url: '?r=admin/games',
            type: 'GET',
            data: obj_data,
            success: function (data) {
                $('.grid_wrapper').html(data);
                // alert("Your email has been sent!");
            },
            error: function(jqXHR, exception, response) {
                console.log(jqXHR, exception, response);
            }

        });

    });



    $('.filter-data-encashment').on('submit', function(e){
        e.preventDefault();
    });

    $('#cash').change(function() {
        if ($(this).prop('checked')) {
            if ($('#conversion').prop('checked')) {
                $('.sum_cash').removeClass('hide');
            }
            $('.cash').addClass('hide');
        } else {
            if ($('#conversion').prop('checked')) {
                $('.sum_cash').addClass('hide');
            }else {
                $('.cash').removeClass('hide');
            }
        }
    });

    $('#conversion').change(function() {
        if ($(this).prop('checked')) {
            if ($('#cash').prop('checked')) {
                $('.conversion').removeClass('hide');
            }else {
                $('.conversion').removeClass('hide');
                $('.conv_cash').addClass('hide');
            }
        } else {
            if ($('#cash').prop('checked')) {
                console.log('kuku')
                $('.conversion').addClass('hide');
                $('.sum_cash').removeClass('hide');
            }else {
                $('.conv_cash').removeClass('hide');
                $('.conversion').addClass('hide');
            }
        }
    });

    // $('.filter-statistics').on('submit', function(e){
    //     e.preventDefault();
    //     console.log('kukus');
    // });
    /*    let dataQuietStartTime = $('#config-quiet_time_start').val();
        let dataQuietEndTime = $('#config-quiet_time_end').val();
        $('#config-quiet_time_start').attr('value', dataQuietStartTime + ":00");
        $('#config-quiet_time_end').attr('value',dataQuietEndTime + ":00");

        $('#change-form-device').submit( function(){
            let valueQuiteStartTime = parseInt($('#config-quiet_time_start').val().slice(0, $('#config-quiet_time_start').length-4));
            let valueQuiteEndTime = parseInt($('#config-quiet_time_end').val().slice(0, $('#config-quiet_time_end').length-4));
            console.log(valueQuiteStartTime, valueQuiteEndTime)
            $('#config-quiet_time_start').attr('value', valueQuiteStartTime);
            $('#config-quiet_time_end').attr('value',valueQuiteEndTime);
        });*/
    function disInput(val) {
        if ($(val).val() === '1') {
            $(val).css({'background-color':'darkred', 'color':'white'});
        } else if($(val).val() === '0') {
            $(val).css({'background-color':'#4caf50', 'color':'white'});
        }
    }

    disInput('#config-disabled');

    $('#config-disabled').change(function(){
        disInput($(this));
    });
    $('#state-on-off span').each(function() {
        if($(this).text() == 'Оффлайн') {
            $(this).parent().css({'background-color':'darkred'});
            $(this).css({'color':'white'});
        }else {
            $(this).parent().css({'background-color':'#4caf50'});
            $(this).css({'color':'white'});
        }
    });

    $('.btn-set a').click(function(e){
        e.preventDefault();
        console.log($(this).attr('href'))
        $(this).attr('href');
        $(window).scrollTop();
        document.location.href = $(this).attr('href')+ "&scrollTop=" + $(window).scrollTop();

    });
});
