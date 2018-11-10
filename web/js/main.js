$(document).ready(function(){
    $('.btn-filter button').click(function(){
        $('.filters').removeClass('hide');
    });



    $("#go-game").click(function(){

        let id_inp = $('#search-game').val();
        let date_inp_first = $('#date_first').val();
        let date_inp_second = $('#date_second').val()
        console.log(id_inp,date_inp_first, date_inp_second);
        let obj_data = {
            'id': id_inp,
            'date_first':date_inp_first,
            'date_second': date_inp_second
        }

        console.log(obj_data);
        $.ajax({
          url: "?r=admin/games",
          type: 'GET',
          data: obj_data,
          success: function (data) {
            console.log('success',data)
            // alert("Your email has been sent!");
          },
          error: function(jqXHR, exception, response) {
            console.log(jqXHR, exception, response );
          }

        });

    });
});
