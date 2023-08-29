<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h1>Stream Events</h1>

        <h3>Total Revenue in the past 30 days </h3>
        <label>Donation</label> : <label id="donation"></label><br>
        <label>Merch Sale</label> : <label id="merch_sale"></label><br>
        <label>Subscriber</label> : <label id="subscriber"></label>

        <h3>Total amount of followers in the past 30 days</h3>
        <label id="followerNumber"></label>

        <h3>Top 3 items, best selling in the past 30 days</h3>
        <label id="top3bestSale"></label>


        <ul id ="message_list">

        </ul>

        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            let f_last_date = '';
            let s_last_date = '';
            let d_last_date = '';
            let m_last_date = '';
            let record_number = 100;

            function getMessage(){
                $.get('/message?f='+f_last_date+'&s='+ s_last_date+'&d='+ d_last_date+'&m='+ m_last_date
                                    + "&record_number" + record_number).done(function(data){
                        for (let record of data['data']) {
                            let check_read = ""
                            if (record['read'] == 0) {
                                check_read = "unread";
                            } else {
                                check_read = "read";
                            }

                            $('#message_list').append('<li color="red">' + record['msg'] + '  ('+ check_read + ", " + record['created_at'] + ')</li>');
                        }
                        $('#message_list').append('<li>____________________________________________________________________________________________</li>');

                        f_last_date = data['last_dates']['f'];
                        s_last_date = data['last_dates']['s'];
                        d_last_date = data['last_dates']['d'];
                        m_last_date = data['last_dates']['m'];
                });
            }

            function getSummaryData() {
                $.get('/revenue').done(function(data){
                    $('#donation').text(data["donation"]);
                    $('#merch_sale').text(data["merch_sale"]);
                    $('#subscriber').text("Tier1) " + data["subscriber"]["1"] + ",  Tier2) " + data["subscriber"]["2"] + ",  Tier3) " + data["subscriber"]["3"])
                });

                $.get('/followerNumber').done(function(data){
                    $('#followerNumber').text(data);
                });

                $.get('/top3bestSale').done(function(data){
                    for (item of JSON.stringify(data)) {
                        $('#top3bestSale').append(item);
                    }
                });
            }


            $(document).ready(function() {
                getMessage();
                getSummaryData();

                $(window).scroll(function(){
                    var scrT = $(window).scrollTop();
                    console.log(scrT, $(document).height() - $(window).height()); //스크롤 값 확인용

                    if(Math.ceil(scrT) == $(document).height() - $(window).height()){
                        getMessage();
                    }         
                });

            
            });
        </script>

    </body>
</html>