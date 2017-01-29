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
        echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
        exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>View Note</title>
        <link rel="stylesheet" href="include/css/view.css" />
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

                                $noteObj = new noteClass();
                
                                $noteObj = $dbObj->findNoteByID($noteID);

                                if ( $noteObj == '' || is_null($noteObj) ) {
                                    echo "<h3 style='color:#084887'>Sorry your note could not be found. Please try again later.</h3>";
                                    echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                                    exit();
                                } else {
                                    if ($noteObj->noteID == $noteID)
                                    {
                                        echo '<h1>Note Details</h1>';
                                        $createTableFromObj = '<div class="tableClass"><table><tbody>';
                                        $createTableFromObj .= '<tr class="odd"><td class="colName">Author</td><td>'.$noteObj->authorName.'</td></tr>';
                                        $createTableFromObj .= '<tr class="even"><td class="colName">Subject</td><td>'.$noteObj->subject.'</td></tr>';
                                        $createTableFromObj .= '<tr class="odd"><td class="colName">Note</td><td>'.$noteObj->body.'</td></tr>';
                                        $createTableFromObj .= '<tr class="even"><td class="colName">Date Created</td><td>'.$noteObj->dateCreated.'</td></tr>';
                                        $createTableFromObj .= '<tr class="odd"><td class="colName">Date Edited</td><td>'.$noteObj->dateModified.'</td></tr>';
                                        $createTableFromObj .= '<tr class="even"><td class="colName">Note Length</td><td>'.$noteObj->noOfChars.'</td></tr>';
                                        $createTableFromObj .= '</tbody></table></div>';

                                        echo $createTableFromObj;

                                        echo '<p><a href="edit.php?noteID='.$noteID.'"><img src="include/img/pencil-yellow-icon.png" style="width:65px; height:65px; margin: 2%;"></a> <a href="delete.php?noteID='.$noteID.'" onclick="confirmDelete()"><img src="include/img/yellow-document-cross-icon.png" style="width:65px; height:65px; margin: 2%;"></a></p>';
                                    } else {
                                        echo "<h3 style='color:#084887'>Sorry your note could not be found. Please try again later.</h3>";
                                        echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                                        exit();
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
		<p><a href="overview.php"><img src='include/img/yellow-home-icon.png' class="homeImage"></a></p>
	</body>
</html>