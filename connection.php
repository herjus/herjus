<?php include 'mainHeader.php' ?>

<div class="conn">
    <h2>MySQL Server status</h2>
       <?php
    
            $sql = "SELECT * FROM users;";
            $results = mysqli_query($conn, $sql);
            $resultsCheck = mysqli_num_rows($results);
        ?>
    <div class ="connectionStatus">
        <?php
            echo $conn ? 'Connection established with server' : 'no connection with server' ; 
        ?>
        
    </div>
    
    <?php
    echo '<br>' . '<br>' . 'Members signed up: ' . '<br>';
    if ($resultsCheck > 0)
    {
        echo $resultsCheck;
    }


    ?> 
</div>

<div class="conn">
    <h2>Server Info</h2>
    <?php
    $server = [
            'Host Server Name' => $_SERVER['SERVER_NAME'],
            'Host Header' => $_SERVER['HTTP_HOST'],
            'Server Software' => $_SERVER['SERVER_SOFTWARE'],
            'Server Protocol' => $_SERVER['SERVER_PROTOCOL'],
            'Document Root' => $_SERVER['DOCUMENT_ROOT'],
            'Current Page' => $_SERVER['PHP_SELF'],
            'Script Name' => $_SERVER['SCRIPT_NAME'],
            'Absolute Path' => $_SERVER['SCRIPT_FILENAME'],
            'Request Uri' => $_SERVER['REQUEST_URI']
        ];
        echo 'Host Server Name: ' . $server['Host Server Name'] . '<br>';
        echo 'Host Header: ' . $server['Host Header'] . '<br>';
        echo 'Server Software: ' . $server['Server Software'] . '<br>';
        echo 'Server Protocol: ' . $server['Server Protocol'] . '<br>';
        echo 'Document Root: ' . $server['Document Root'] . '<br>';
        echo 'Current Page: ' . $server['Current Page'] . '<br>';
        echo 'Script Name: ' . $server['Script Name'] . '<br>';
        echo 'Absolute Path: ' . $server['Absolute Path'] . '<br>';
        echo 'Request Uri: ' . $server['Request Uri'] . '<br>';
        ?>
</div>

<div class="conn">
    <h2>Client Info</h2>
    <?php

    $client = [
        'Client System Info' => $_SERVER['HTTP_USER_AGENT'],
        'Client IP' => $_SERVER['REMOTE_ADDR'],
        'Remote Port' => $_SERVER['REMOTE_PORT']
    ];
    echo 'Client System Info: ' . $client['Client System Info'] . '<br>';
    echo 'Client IP: ' . $client['Client IP'] . '<br>';
    echo 'Remote Port: ' . $client['Remote Port'] . '<br>';


    ?>
</div>
<?php include_once 'footer.php' ?>

    