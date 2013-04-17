var last_search = "";

$(document).ready(function() {



    $("#search_form").on('submit', function(e) {

        request_search();
        e.preventDefault();

    });

    //carry out a search at 2 second intervals in case user changes search value
    setInterval(request_search, 2000);
    



});


function request_search() {


    var search_request = $(".search_request").val();
    if (!(search_request == "") && (!(search_request == last_search))) {
        
        $('.button').css('display', 'none').delay(1000);
     $('.loader').css('display', 'inline');

        $.post('request.php', {"search": search_request}, function(result) {
            $(".loader").css('display', 'none');
            if (result.status == "OK") {

                $(".display_results").html(result.results);

            } else if (result.status == "result_empty") {

                $(".display_results").html('<p class="no_results">No results found </p>');

            }
              

               $('.button').fadeIn();

        }, "json");
    }
    
    if(search_request == ""){
        $(".display_results").html("");
    }
    
   
    last_search = $(".search_request").val();
}
