<?php
    namespace dkhabiya\p3\Application;
    include_once '/database.php';

    $constantUserName = "admin";
    $constantPassword = "bed128365216c019988915ed3add75fb";

    function loadLogin($userName, $password, $error) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Note Taking App</title>
        <link rel="stylesheet" href="include/css/login.css" />
    </head>
    <body>
        <span class="headerClass">
            <br/>
            <br/>
            <img src="include/img/yellow-notes-icon.png" class="imageMain" alt='Home'> 
            <h1>Notes</h1><br/><span class="subMsg">Simple PHP Note Application</span>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php
                if ($error != '') {
                    echo '<div style="padding:4px; color:red; font-weight: bold;">'.$error.'</div>';
                }
            ?>
            <h3>User Login</h3>
            <p>The fields marked with '<span>*</span>' are mandatory.</p>
            <form method="POST">
                <h4>
                    <label>User Name</label>
                    <input type="text" name="userName" value="<?php echo $userName; ?>"><span> * </span>
                </h4>
                <h4>
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo $password; ?>"><span> * </span>
                </h4>
                <input type="submit" name="Login" value="Login">
            </form>
        </span>
        <br/>
    </body>
</html>

<?php
    }
    
    if (isset($_POST['Login'])) {
        session_start();
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if ( trim($userName) == "" || trim($password) == "" ) {
            $error = 'ERROR: Please fill in all required fields !';
            loadLogin($userName, $password, $error);  
        } else {
            if ( $userName == $constantUserName ) {
                if ( md5($password) == $constantPassword ) {
                    $_SESSION['userName'] = $userName;
                    $_SESSION['loggedIn'] = true;
                    header("Location: overview.php");
                } else {
                    $error = 'ERROR: Invalid password !';
                    session_destroy();
                    loadLogin($userName, '', $error);    
                }
            } else {
                $error = 'ERROR: Invalid username !';
                session_destroy();
                loadLogin('', $password, $error);
            }
        }
    }
    else
    {
        
        loadLogin('','','');    
        
    }
?>