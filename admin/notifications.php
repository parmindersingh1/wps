<?php

session_start();
require_once dirname(__FILE__).'/../api/class.user.php';
require_once dirname(__FILE__).'/../api/class.vehicle.php';
$user_login = new USER();
$user_vehicle = new Vehicle();

include('header.php'); 

    $stmt = $user_login->runQuery("select * FROM tbl_users WHERE userStatus = 'Y' AND gcm_regid IS NOT NULL AND gcm_regid <> ''");
    $stmt->execute();
    $all_users =  $stmt->fetchAll(PDO::FETCH_ASSOC);

    $no_of_users = count($all_users);
 ?>
        
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Home</li>
            </ol>
        </div><!--/.row-->
        

        




            <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Users
                    <a href="send_notifications.php?id=<?= $currentUser->userID ?>" class="btn btn-info pull-right">Send to All</a></div>
                    <div class="panel-body">                        
                        <div class="table-responsive">
                        <table id="usertable" class="table">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>                                
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($all_users as $user) {
                                ?>      
                                            
                                        <tr>
                                            <td><a href="user.php?id=<?= $user['userID'] ?>"><?= $user['userEmail'] ?></a></td>
                                            <td><?= $user['first_name'].' '.$user['last_name'] ?></td>
                                           
                                            <td><?= $user['phone'] ?></td>
                                            
                                            <td><a href="send_notification.php?id=<?= $user['userID']?>" data-original-title="Send Notification" data-toggle="tooltip" type="button" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i> Send Notification</a></td>
                                        </tr>
                                <?php       
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
</div>
                </div>
            </div>
        </div><!--/.row-->  






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

           
    </script>   
</body>

</html>




















            
             
       
       


        
         
       