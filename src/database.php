<?php
    namespace dkhabiya\p3\Database {
        include_once '/include/class/noteClass.php';
        use \PDO;
        use \dkhabiya\p3\Application\noteClass;
        class DatabaseOperations {

            private $databaseObj;

            public function __construct() {

                $this->databaseObj = new PDO('sqlite:databases\database.sqlite');
                
                $this->databaseObj->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                
                if( !$this->databaseObj ) {
                    echo $this->databaseObj->lastErrorMsg();
                }
                else {
                    $this->databaseObj->exec('CREATE TABLE IF NOT EXISTS notes(noteID INTEGER PRIMARY KEY AUTOINCREMENT, authorName VARCHAR(50) NOT NULL, subject VARCHAR(200) NOT NULL, noteBody BLOB, noOfChars INTEGER, dateCreated TEXT, dateModified TEXT)');
                }
            }

            public function findAllNotes() {
                
                $allNotes = array();

                $resultSet = $this->databaseObj->query('select * from notes');
                
                $i=0;

                foreach ($resultSet as $key) {
                    $noteObj = new noteClass();
                    $noteObj->noteID = $key['noteID'];
                    $noteObj->authorName = $key['authorName'];
                    $noteObj->subject = $key['subject'];
                    $noteObj->body = $key['noteBody'];
                    $noteObj->noOfChars = $key['noOfChars'];
                    $noteObj->dateCreated = $key['dateCreated'];
                    $noteObj->dateModified = $key['dateModified'];
                
                    $allNotes[$i] = $noteObj;
                    ++$i;
                }

                return $allNotes;
            }

            public function findNoteByID($noteID) {
                $noteObj = new noteClass;
                $statement = $this->databaseObj->prepare('select noteID, authorName, subject, noteBody, noOfChars, dateCreated, dateModified from notes where noteID = :noteID');
                $statement->bindParam(':noteID',$noteID);
                $statement->execute();

                if ( $key = $statement->fetch() ) {

                    $noteObj->noteID = $key['noteID'];
                    $noteObj->authorName = $key['authorName'];
                    $noteObj->subject = $key['subject'];
                    $noteObj->body = $key['noteBody'];
                    $noteObj->noOfChars = $key['noOfChars'];
                    $noteObj->dateCreated = $key['dateCreated'];
                    $noteObj->dateModified = $key['dateModified'];

                    return $noteObj;
                } else {
                    return null;
                }                
            }

            public function saveNote($noteObj) {

                $authorName = $noteObj->authorName;
                $subject = $noteObj->subject;
                $noteBody = $noteObj->body;
                $noteID = $noteObj->noteID;
                $noOfChars = $noteObj->noOfChars;
                
                date_default_timezone_set('America/Chicago');
                $dateCreated = date('d M Y \- h\:i\:s A');
                $dateModified = date('d m Y \- h\:i\:s A');
                
                
                if ( $noteID == '' ) {
                    
                    $statement = $this->databaseObj->prepare('INSERT INTO notes(authorName, subject, noteBody, noOfChars, dateCreated, dateModified) values (:authorName, :subject, :noteBody, :noOfChars, :dateCreated, :dateModified)');
                    $statement->bindParam(':authorName',$authorName);
                    $statement->bindParam(':subject',$subject);
                    $statement->bindParam(':noteBody',$noteBody);
                    $statement->bindParam(':noOfChars',$noOfChars);
                    $statement->bindParam(':dateCreated',$dateCreated);
                    $statement->bindParam(':dateModified',$dateModified);
                    
                    return $statement->execute();

                } else {
                    
                    $statement = $this->databaseObj->prepare('UPDATE notes set authorName = :authorName, subject = :subject, noteBody = :noteBody, noOfChars = :noOfChars, dateModified = :dateModified where noteID = :noteID');
                    $statement->bindParam(':authorName',$authorName);
                    $statement->bindParam(':subject',$subject);
                    $statement->bindParam(':subject',$subject);
                    $statement->bindParam(':noteBody',$noteBody);
                    $statement->bindParam(':noOfChars',$noOfChars);
                    $statement->bindParam(':dateModified',$dateModified);
                    $statement->bindParam(':noteID',$noteID);

                    return $statement->execute();
                }

            }

            public function deleteNote($noteID) {

                $statement = $this->databaseObj->prepare('DELETE FROM notes where noteID = :noteID');
                    $statement->bindParam(':noteID', $noteID);

                    return $statement->execute();

            }
        }
    }
?>