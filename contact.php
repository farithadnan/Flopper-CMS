 <?php  include "includes/header.php"; ?>
<?php 
    //This function is not perfect at the moment, bcs the from header is not been detected by the email, to reset to default go change the config in php.ini and sendmail.ini file
    if(isset($_POST['submit']))
    {   

        $from_email = mysqli_real_escape_string($connection, $_POST['email']);
        $to_mail = "doerlap@gmail.com";
        $subject = mysqli_real_escape_string($connection, $_POST['subject']);
        $body = mysqli_real_escape_string($connection, $_POST['body']);
        $sender = "From:" . $from_email;

        if(!empty($from_email) && !empty($subject) && !empty($body))
        {
            if(mail($to_mail, $subject, $body, $sender  ))
            {
                $message  =  "<div class='alert alert-success '>";
                $message .=  "Your request has been submitted";
                $message .=   "</div>";
            }       
             else
            {
                $message  =  "<div class='alert alert-danger '>";
                $message .=  "Your request has failed to be submit. Please try again. ";
                $message .=   "</div>";
            }
        }
        else
        {
            $message  =  "<div class='alert alert-danger '>";
            $message .=  "Your request fill is empty. Please try again. ";
            $message .=   "</div>";
        }


    } else {
        $message = "";
    }
 ?>
    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message; ?></h6>
                       
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject" required>
                        </div>
                         <div class="form-group">
                            <label for="body" class="sr-only">Body</label>
                            <textarea type="text" class="form-control" name="body" id="body" cols="50" rows="10">
                            </textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
