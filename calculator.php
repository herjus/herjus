<?php include 'mainHeader.php' ?>
    <div class="calcContainer">
    <form>
        <input type="text" name="num1" placeholder="Number 1" value="<?php if(isset($_GET['num1'])) echo $_GET['num1'];?>" />
        <input type="text" name="num2" placeholder="Number 2" value="<?php if(isset($_GET['num2'])) echo $_GET['num2'];?>"/>
        <select name="operator">
            <option>None</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="add") echo 'selected="selected"';}?> >add</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="subtract") echo 'selected="selected"';}?> >subtract</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="multiply") echo 'selected="selected"';}?> >multiply</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="divide") echo 'selected="selected"';}?> >divide</option>
        </select>
        <br>
        <button type="submit" name="submit" value="submit"> Calculate</button>
    </form>

    <p class="calculator-box">The answer is: 

        <div class="calcMessage">   
           <?php
                if (!isset($_GET['submit']))
                {
                    echo "enter inputs! ";
                }
             
            
                else{
                    $num1 = $_GET['num1'];
                    $num2 = $_GET['num2'];
                    $operator = $_GET['operator'];

                    switch ($operator){
                        case "None";
                            echo "Select operation";
                            break;
                            
                        case "add";
                            echo $num1 + $num2; break;
                        case "subtract";
                            echo $num1 - $num2; break;
                        case "multiply";
                            echo $num1*$num2; break;
                        case "divide";
                            echo $num1/$num2; break;
                    }
            }?>
        </div>
    </p>
        
    </div>
<?php include 'footer.php' ?>