  <?php

  session_start();
  require_once dirname(__FILE__).'/../api/class.user.php';
  $user_login = new USER();

  
  $_SESSION['oldURL'] = $_SERVER['REQUEST_URI'];
  if(!isset($_GET["searchID"]) ){
    $user_login->redirect('../index.php');
  } else {
    $searchID = $_GET['searchID'];

    $stmt = $user_login->runQuery("SELECT  u.userEmail as email, u.phone as phone,us.location as location, CONCAT_WS(' ',u.first_name,u.last_name) as name,u.gender as gender, v.name as vehicle_name, v.model_no as vehicle_model,  DATE_FORMAT(us.created_at,'%d %b %Y %r') as date_of_search, u.photo as photo FROM tbl_users_searches as us JOIN tbl_users as u on u.userID = us.user_id JOIN tbl_vehicles as v on v.vehicleID = us.vehicle_id WHERE  us.id = :search_id");
    $result = $stmt->execute(array(":search_id" => $searchID));
    $search   = $stmt->fetch(PDO::FETCH_ASSOC);
    
  }
  include('header.php');



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
        <div class="panel-heading"><?php echo ucwords($search['name'])?></div>
        <div class="panel-body">  





          <div class="container">
            <div class="row">
              
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
                
                
                <div class="panel panel-info">                   
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3 col-lg-3 " align="center"><?php
                        echo '<img src="data:image/jpeg;base64,'.base64_decode(base64_encode( $search['photo'] )).' " class="img-circle img-responsive"/>';
                        ?>
                      </div>
                      
                      
                      <div class=" col-md-9 col-lg-9 "> 
                      <div class="table-responsive">
                        <table class="table table-user-information">
                          <tbody>                            
                            <tr>
                              <td>Full Name</td>
                              <td><?php echo ucwords($search['name'])?></td>
                            </tr>

                                                        
                            <tr>
                              <tr>
                                <td>Gender</td>
                                <td><?php echo $search['gender']?></td>
                              </tr>
                              <tr>
                                <td>Phone</td>
                                <td><?php echo $search['phone']?></td>
                              </tr>
                              <tr>
                                <td>Email</td>
                                <td><a href="mailto:<?php echo $search['email'] ?>"><?php echo $search['email']?></a></td>
                              </tr> 
                              <tr>
                                <td>Vehicle Name</td>
                                <td><?php echo $search['vehicle_name']?></td>
                              </tr> 
                              <tr>
                                <td>Vehicle Number</td>
                                <td><?php echo $search['vehicle_model']?></td>
                              </tr> 

                              <tr>
                                <td>Date/Time of Search</td>
                                <td><?php echo $search['date_of_search']?></td>
                              </tr>

                              <tr>
                                <td>Location of Search</td>
                                <td><?php echo $search['location']?></td>
                              </tr>
                            
                              
                            </tbody>
                          </table>
                          </div>
                         
                          
                          
                        </div>
                      </div>
                    </div>
                                        
                  </div>
                </div>
              </div>
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
      $('#usertable').DataTable();
    } );
  </script> 
</body>

</html>

