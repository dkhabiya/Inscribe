<?php
    namespace dkhabiya\p3\Application;
    include_once '/include/class/noteClass.php';
    include_once 'database.php';
    $c = 0;

    $dbObj = new \dkhabiya\p3\Database\DatabaseOperations();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Note Taking App</title>
        <link rel="stylesheet" href="include/css/overview.css" />
    </head>
    <body>
        
        <?php
            if (isset($_SERVER['HTTP_REFERER'])) {

                session_start();
                
                $userName = $_SESSION['userName'];
                $loggedIn = $_SESSION['loggedIn'];

                if ( isset($userName) ) {
                    if ( is_null($userName) ) {
                        echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                        echo "<p><a href='overview.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                        $_SESSION['userName'] = '';
                        $_SESSION['loggedIn'] = false;
                        session_destroy();
                        exit();
                    } else {
                        if ( isset($loggedIn) ) {
                            if ($loggedIn) { ?>

                            <span class="headerClass">
                                <span><h1><?php echo $userName; ?></h1><br/></span>
                                <form method="POST">
                                    <input type="submit" name="Logout" value="Logout">
                                </form>
                            </span>
                            <h2>Notes Overview</h2>

                            <?php    
                                
                                //Logout
                                if (isset($_POST['Logout'])) {
                                    unset($_SESSION['userName']);
                                    unset($_SESSION['loggedIn']);
                                    session_destroy();
                                    header("Location: index.php");
                                    exit();
                                }

                                $allNotes = array();

                                $allNotes = $dbObj->findAllNotes();

                                $count = count($allNotes);

                                echo '<h5>Number of Notes : '.$count.'</h5>';

                                // Create table
                                $createTableFromObj = '<div class="tableClass"><table>';
                                $createTableFromObj .= '<thead><th>#</th>';
                                $createTableFromObj .= '<th>Subject</th>';
                                $createTableFromObj .= '<th>Date Created</th>';
                                $createTableFromObj .= '<th>No. Of Characters</th></thead><tbody>';

                                $i = 1;

                                foreach ($allNotes as $key ) {

                                    $noteObj = new noteClass();

                                    $noteObj = $key;

                                    $cssClass = "odd";

                                    if ( ($c++)%2 == 1 ) {
                                        $cssClass = "even";
                                    }
                                    else {
                                        $cssClass = "odd";
                                    }
                                    
                                    $createTableFromObj .= '<tr class="'.$cssClass.'">';
                                    $createTableFromObj .= '<td>' .$i. '</td>';
                                    $createTableFromObj .= '<td><a class="linkSubject" href="view.php?noteID='.$noteObj->noteID.'">' .$noteObj->subject. '</a></td>';
                                    $createTableFromObj .= '<td>' .$noteObj->dateCreated. '</td>';
                                    $createTableFromObj .= '<td>' .$noteObj->noOfChars. '</td>';
                                    $createTableFromObj .= '</tr>';
                                    
                                    ++$i;
                                }
                                
                                $createTableFromObj .= '</tbody></table></div>';
                                echo $createTableFromObj; 

                            }
                            else {
                                echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                                echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                                $_SESSION['userName'] = '';
                                $_SESSION['loggedIn'] = false;
                                session_destroy();
                                exit();
                            }
                        }
                    }
                }   
                else {
                    echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                    echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                    exit();
                }            
            } else {
                echo "<h3 style='color:#084887'>Please login to view notes.</h3>";
                echo "<p><a href='index.php'><img src='include/img/yellow-home-icon.png' style='width:65px; height:65px'></a></p>";
                exit();
            }
            
        ?>
        <br/>
        <a href="new.php"><img class="addImage" src="include/img/yellow-document-plus-icon.png" alt="Add New Note"></a>
    </body>
</html>
