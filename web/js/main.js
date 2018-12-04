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

        let link = "http://zags.zu/web/index_cop_old.php?r=admin/games&page=" + data;
        // console.log(link);

        $.ajax({
          url: "?r=admin/games",
          type: 'GET',
          data: {"link":link},
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
            date_inp_first = "1970-02-12";
        } else if (date_inp_second == '') {
            date_inp_second = "2670-02-12";
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
          url: "?r=admin/games",
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
        console.log('form');
    });

    $('.checkbox-inp-stat').change(function() {
        // console.log($(this).val(), $(this).prop("checked"));
        if ($(this).prop("checked")) {
            if ($(this).val() === 'conversion') {
                $('.'+$(this).val()).removeClass('hide');
                $('.conv_cash').addClass('hide')
            } else {
                $('.'+$(this).val()).addClass('hide');

            }
        } else {
            if ($(this).val() === 'cash') {
                $('.'+$(this).val()).removeClass('hide');
            } else {
                $('.'+$(this).val()).addClass('hide');
                $('.conv_cash').removeClass('hide')
            }
        }
    });

    // $('.filter-statistics').on('submit', function(e){
    //     e.preventDefault();
    //     console.log('kukus');
    // });

});
