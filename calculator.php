<?php include 'mainHeader.php'; include 'class/calculator.class.php'; ?>

    <div class="calcContainer">
    <form method="GET">
        <input type="number" name="num1" placeholder="Number 1" value="<?php if(isset($_GET['num1'])) echo $_GET['num1'];?>" />
        <input type="number" name="num2" placeholder="Number 2" value="<?php if(isset($_GET['num2'])) echo $_GET['num2'];?>"/>
        <select name="operator">
            <option>None</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="add") echo 'selected="selected"';}?> >add</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="subtract") echo 'selected="selected"';}?> >subtract</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="multiply") echo 'selected="selected"';}?> >multiply</option>
            <option <?php if(isset($_GET['operator'])) {if($_GET['operator'] =="divide") echo 'selected="selected"';}?> >divide</option>
        </select>
        <br>
        <button type="submit" name="submit" value ="submit"> Calculate</button>
    </form>

    <p class="calculator-box">The answer is: 

        <div class="calcMessage">   
           <?php
                if (!isset($_GET['submit']) || empty($_GET['num1']) || empty($_GET['num2'])) echo "enter numbers! ";
                else if(($_GET['operator'])=="None") echo "select operation.";
                else
                {
                    $num1 = $_GET['num1'];
                    $num2 = $_GET['num2'];
                    $operator = $_GET['operator'];
                    $calc = new Calc($num1, $num2, $operator);
                    echo $calc->getResult();
                }
             ?>
        </div>
    </p>
        
    </div>
<?php include 'footer.php' ?>