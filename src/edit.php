<?php
	namespace dkhabiya\p3\Application;
	include_once '/include/class/noteClass.php';
    include_once 'database.php';
	
	$dbObj = new \dkhabiya\p3\Database\DatabaseOperations();

    if ( isset($_GET['noteID']) != '' ) {
		$noteID = $_GET['noteID'];
	}
	else {
		echo "<h3 style='color:#084887'>Sorry your note could not be found. Please try again later.</h3>";
        echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px' alt='Home'></a></p>";
        exit();
	}	

	function loadForm($subject, $body, $authorName, $error)
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edit Note</title>
		<link rel="stylesheet" href="include/css/form.css" />
	</head>
	<body>
		<h1>Edit Note</h1>
		<h5>The fields marked with <span>*</span> are mandatory.</h5>

		<?php
			if ($error != '') {
				echo '<div style="padding:4px; color:red; font-weight:bold;">'.$error.'</div>';
			}
		?>

		<form action="" method="POST">
			<div>
				<h4>
					<label>Name </label>
					<input type="text" name="authorName" value="<?php echo $authorName; ?>" /><span> * </span>
				</h4>
				<h4> 
					<label>Subject </label> 
					<input type="text" name="subject" value="<?php echo $subject; ?>" /><span> * </span>
					<br/>
				</h4>
				<h4>
					<label>Note </label>
					<textarea id="note" name="body" rows="10" cols="40" ><?php echo $body; ?></textarea>
					<br/>
				</h4>
				<input type="image" name="Save" alt="Save" src="include/img/yellow-disk-icon.png" value="Save" class="submitClass">
			</div>
		</form>
	</body>
</html>
<?php
	}

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
        				if (isset($_POST['Save'])) {   	

					    	$noteObj = new noteClass();
					            
					        $noteObj->noteID = $noteID;
					        $noteObj->authorName = trim($_POST['authorName']);
							$noteObj->subject = trim(strip_tags($_POST['subject']));
							$noteObj->body = trim(strip_tags($_POST['body']));
							
							//Mandatory fields
							if ( trim($noteObj->subject) == "" || trim($noteObj->authorName) == ""  ) {
								$error = 'ERROR: Please fill in all required fields!';
								loadForm($noteObj->subject, $noteObj->body, $noteObj->authorName, $error);	
								exit();	
							} else {
								if (!ctype_alnum(trim($noteObj->authorName))) {
									$error = 'ERROR: Author Name cannot have special characters!';
									loadForm($noteObj->subject, $noteObj->body, $noteObj->authorName, $error);	
									exit();
								}
							}

							$noteObj->noOfChars = strlen(str_replace(array("\n", "\r\n", "\r"), '', $_POST['body']));

							if($dbObj->saveNote($noteObj)) {
								echo "<h1 style='color:#084887'>Note Successfully Saved !</h1>";
								echo "<p><a href='overview.php'><img class='homeImage' src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
								exit();			
							} else {
								echo "<h3 style='color:#084887'>Sorry could not save your note at this time. Please try again later.</h3>";
								echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' alt='Home' style='width:65px; height:65px'></a></p>";
								exit();	
							}
					        
					        echo "<h3 style='color:#084887'>Note Successfully Saved !</h3>";
							echo "<p><a href='index.php'><img class='homeImage' src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
							exit();
					    }			
					    else {
					    	
					    	$noteObj = new noteClass();
					        	
					        $noteObj = $dbObj->findNoteByID($noteID);

					        if ( $noteObj == '' || is_null($noteObj) ) {
					            echo "<h3 style='color:#084887'>Sorry your note could not be found. Please try again later.</h3>";
					            echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
					            exit();
					        } else {
					            if ( $noteObj->noteID == $noteID ) {
					            	loadForm($noteObj->subject, $noteObj->body, $noteObj->authorName, '');
					            } else {
					            	echo "<h3 style='color:#084887'>Sorry could not find your note. Please try again later.</h3>";
						        	echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
						        	exit();
					            }
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