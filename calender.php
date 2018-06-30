<?php include 'mainHeader.php' ?>
    
    <div class="timeBox">
       <?php
            function getDay(){
                $dayofweek = date("w");

                switch ($dayofweek){
                    case 0:
                        echo "It's Sunday"; break;
                    case 1;
                        echo "It's Monday"; break;
                    case 2;
                        echo "It's Tuesday"; break;
                    case 3;
                        echo "It's Wednesday"; break;
                    case 4;
                        echo "It's Thursday"; break;
                    case 5;
                        echo "<p>It's Friday<p>"; break;
                    case 6;
                        echo "<p>It's Saturday<p>"; break;
                }
            }
        getDay();

        echo "<br>";
        //echo date('H:i:s');
        $date = date("d.m.Y H:i");
        echo $date;
        ?> 
    </div>
    
    <div class="mainContent">
        <picture>
            <img src="images/trumpmarines.jpg">
        </picture>
    </div>
<?php include 'footer.php' ?>