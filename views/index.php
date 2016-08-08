<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment</title>
    </head>
    <body>
        <?php 
        $showArray = $data; 
        
        echo "使用者:" . $showArray[0]['userid'] . "<br>";
        echo "金錢餘額:" . $showArray[0]['money'];
        
        ?>
        
    </body>
</html>