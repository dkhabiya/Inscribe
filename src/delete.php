<?php
	namespace dkhabiya\p3\Application;
    include_once '/include/class/noteClass.php';
    include_once 'database.php';
        
    $dbObj = new \dkhabiya\p3\Database\DatabaseOperations();

    if (!(isset($_POST['Yes']))) {
    	if (!(isset($_POST['No']))) {
    		echo "<h3 style='color:#084887'>Are you sure ?</h3>";
    		echo '<form method="POST"><input type="submit" name="Yes" value="Yes" style="padding:5px 15px; cursor:pointer; -webkit-border-radius: 5px; border-radius: 5px; font-size: 15px; font-family: "Tahoma"; font-weight: bold;"><input type="submit" name="No" value="No" style="padding:5px 15px; cursor:pointer; -webkit-border-radius: 5px; border-radius: 5px; font-size: 15px; font-family: "Tahoma"; font-weight: bold;"></form>';	
    	}    	
    }

    if ( isset($_GET['noteID']) != '' ) {
		$noteID = $_GET['noteID'];
	}
	else {
		echo "<h3 style='color:#084887'>Sorry your note could not be found. Please try again later.</h3>";
        echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
        exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Delete Note</title>
	</head>
	<body>
		<?php
			
			if (isset($_SERVER['HTTP_REFERER'])) {
				
				session_start();

		        $userName = $_SESSION['userName'];
		        $loggedIn = $_SESSION['loggedIn'];
		        
		        if ( isset($userName) ) {
		        	if ( is_null($userName) )  {
		        		echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                        echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                        $_SESSION['userName'] = '';
                        $_SESSION['loggedIn'] = false;
                        session_destroy();
                        exit();
		        	} else {
		        		if ( isset($loggedIn) ) {
		        			if ($loggedIn) {
		        				
		        				if (isset($_POST['Yes'])) {
									if ( $dbObj->deleteNote($noteID) ) {
										echo "<h3 style='color:#084887'>Note Successfully Deleted !</h3>";
										echo "<p><a href='overview.php'><img class='homeImage' src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
										exit();
									} else {
										echo "<h3 style='color:#084887'>Sorry could not delete your note at this time. Please try again later.</h3>";
										echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
										exit();
									}
								}
								else {
									if (isset($_POST['No'])) {
										header("Location: overview.php");
									}
								}
		        			}
		        		} else {
		        			echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                            echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                            $_SESSION['userName'] = '';
                            $_SESSION['loggedIn'] = false;
                            session_destroy();
                            exit();
		        		}
		        	}

		        } else {
		        	echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                    echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                    $_SESSION['userName'] = '';
                    $_SESSION['loggedIn'] = false;
                    session_destroy();
                    exit();
		        }

			} else {
				echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                exit();
			}
		?>		
	</body>
</html>