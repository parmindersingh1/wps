<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

if(isset($_GET['id'])) {
    $userID = $_GET['id'];
    $stmt = $user_login->runQuery("select userID , gcm_regid FROM tbl_users WHERE userID= :user_id");

    $stmt->execute(array(":user_id" => $userID));
    $user =  $stmt->fetch();

    
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
 ?>
        
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Home</li>
            </ol>
        </div><!--/.row-->
        

        <div id="gcmStatus" class="alert alert-success">
          
        </div>




         <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <hr/>            
            <form id="formall" name="" method="post" onsubmit="return sendPushNotifications()">
                                       
                <textarea class="form-control" rows="3" name="message" cols="25" class="txt_message" placeholder="Type message here"></textarea>
                <p></p>
           
                <input type="hidden" name="userId" value="<?php echo $user["userID"] ?>"/>
                <input type="submit" class="send_btn btn btn-lg btn-primary pull-right" value="Send" onclick=""/>
                </div>
            </form>
                </div>
        </div>






        </div><!--/.main-->

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    
    <script>
        !function ($) {
            $(document).on("click","ul.nav li.parent > a > span.icon", function(){        
                $(this).find('em:first').toggleClass("glyphicon-minus");      
            }); 
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function () {
          if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
          if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })

        $(document).ready(function() {
            $('#vehicletable').DataTable();
        } );

       function sendPushNotifications(){
            var data = $('#formall').serialize();
            $('#formall').unbind('submit');                
            $.ajax({
                url: "device_sendmessages.php",
                type: 'GET',
                data: data,
                beforeSend: function() {
                     $("#gcmStatus").empty().html("<strong>Please Wait...</strong>");
                },
                success: function(data, textStatus, xhr) {
                    $("#gcmStatus").empty().html("<strong>Success</strong>"+data);
                    console.log(data);
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#gcmStatus").empty().html("<strong>Error</strong>"+errorThrown);
                     console.log(errorThrown);
                }
            });
            return false;
        }
    </script>   
</body>

</html>




















            
             
       
       


        
         
       