 <?php  include "includes/header.php"; ?>

<?php 
    require 'vendor/autoload.php';

    // SETTING LANGUAGE VARIABLE
    if(isset($_GET['lang']) && !empty($_GET['lang']))
    {
        $_SESSION['lang'] = $_GET['lang'];

        // WILL RELOAD THE PAGE IF THE SELECTION IS CHANGE
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
            echo "<script type='text/javascript'>location.reload();</script>";
        }
    }
        
    // IF THE SESSION SET IT WILL BE INCLUDING LANGUAGE BASED ON THE USER SELECTION
    if(isset($_SESSION['lang'])){
        include "includes/languages/" . $_SESSION['lang'] . ".php";
     } else {
        include "includes/languages/en.php";
     }

    // SENDING EMAIL
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $options = array(
        'cluster' => 'ap1',
        'encrypted' => true
    );

    // PUSHER API
    $pusher = new Pusher\Pusher($_ENV['APP_KEY'], $_ENV['APP_SECRET'], $_ENV['APP_ID'], $options );

    // AUTHENTICATION
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        $error = [

            'username' => '',
            'email' => '',
            'password' => ''
        ];


        if(strlen($username) < 4)
        {
            $error['username'] = 'Username needs to be longer';
        }

        if(strlen($username) == '')
        {
            $error['username'] = 'Username cannot be empty';
        }

        if(username_exists($username))
        {
            $error['username'] = 'Username already exists. Please try again.';
        }
 
        if(strlen($email) == '' || empty($email))
        {
            $error['email'] = 'Email cannot be empty';
        }

        if(email_exists($email))
        {
            $error['email'] = 'Email already exists. <a href="index.php">Please login</a>';
        }

        if($password == '')
        {
            $error['password'] = 'Password cannot be empty';
        }

        // this will check the error msg in the array, if its empty, it will unset the array or clean the array before executing registration process in the if statement below this loop.
        foreach ($error as $key => $value) {
            
            if (empty($value)) {

                unset($error[$key]);
            }
        }

        if(empty($error))
        {
            register_user($username, $email, $password);

            $data['message'] = $username;
            $pusher->trigger('notifications', 'new_user', $data);
            login_user($username, $password);
        }

    } 
 ?>
<!-- Navigation -->

<?php  include "includes/nav.php"; ?>


<!-- SELECTION TAG FOR CHOOSING LANGUAGE -->
<div class="container">
<form method="get" class="navbar-form navbar-right "  id="language_form" k>
    <div class="form-group">
        <select name="lang" class="form-control" onchange="changeLanguage()">
            <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?>>English</option>
            <option value="es" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'es'){ echo "selected"; } ?>>Spanish</option>
            <option value="my" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'my'){ echo "selected"; } ?>>Malay</option>
        </select>
    </div>
</form>    


<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" value="<?php echo isset($username) ? $username : ''; ?>">
                            <p><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" value="<?php echo isset($email) ? $email : ''; ?>">
                            <p><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>" >
                            <p><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>

                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER; ?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>

<script>
    // IT WILL BE SUBMITING THE FORM
    function changeLanguage(){
        document.getElementById('language_form').submit();
    }
</script>


<?php include "includes/footer.php";?>
