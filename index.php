<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fileupload example</title>
    </head>
    <body>
        <h1>Fileupload example</h1>
        <h2>Formular</h2>
        <!-- $_SERVER['PHP_SELF'] ist eine Variable, die die URL auf die gerade
             angezeigt Website enthaelt. Somit wird beim Abschicken des Formulars
             auf die selbe PHP-Seite verweist. -->
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
            <p>Diese Datei hochladen:</p>
            <input name="uploadFile" type="file" />
            <!-- Dem Submit-Button kann optional auch ein Name (name) gegeben
                 werden. Dann kann die Variable $_POST['<name>'] ueberprueft
                 werden, ob das Formular schon abgeschickt worden ist. -->
            <input type="submit" value="Datei hochladen" />
        </form>
        
        <hr />
        
        <?php
            // Ueberpruefung, ob Formular mit hochzuladennder Datei ueberhaupt
            // schon abgeschickt wurde oder ob Website zum Ersten Mal aufgerufen
            // wurde.
            if (isset($_FILES['uploadFile'])) {
                // Ueberpruefung, ob irgendein Fehler aufgetreten ist.
                if ($_FILES['uploadFile']['error'] > 0)
                {
                  echo 'Problem: ';
                  switch ($_FILES['uploadFile']['error'])
                  {
                    case 1:
                        echo 'File exceeded upload_max_filesize';
                        break;
                    
                    case 2:
                        echo 'File exceeded max_file_size';
                        break;
                    
                    case 3:
                        echo 'File only partially uploaded';
                        break;
                    
                    case 4:
                        echo 'No file uploaded';
                        break;
                    
                    case 6:
                        echo 'Cannot upload file: No temp directory specified.';
                        break;
                    
                    case 7:  
                        echo 'Upload failed: Cannot write to disk.';
                        break;
                  }
                }
                elseif (!is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {
                    echo "File could not upload.";
                }
                else {
                    if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], "data/".$_FILES['uploadFile']['name'])) {
                        echo "Problem: Datei konnte nicht hochgeladen werden.";
                    }
                    else {
                        echo "<strong>Datei erfolgreich hochgeladen!</strong>"."<br />";
                        echo "Dateiname: ".$_FILES['uploadFile']['name']."<br />";
                        echo "Grösse: ".$_FILES['uploadFile']['size']."<br />";
                        echo "Type: ".$_FILES['uploadFile']['type']."<br />";
                    }   
                }
            }
        ?>
        
        <hr />
        
        <h2>Hochgeladene Dateien</h2>
        <ul>
            <?php
                $dataDir = getcwd()."/data";
                $files = scandir($dataDir);
                
                foreach ($files as $file) {
                    if (is_file("data/".$file)) {
                        echo "<li><a href='data/$file'>$file</a></li>";
                    }
                }
            ?>
        </ul>
    </body>
</html>
