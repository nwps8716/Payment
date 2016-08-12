<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SelfBank</title>
        <script  type="text/javascript">
        function check()
        {
        	if(reg.addOrCut.value == "") {
        		alert("未點選取款或存款");
        	} else {
        	    reg.submit();
        	}
        }
        </script>
    </head>
    <body>
        <?php
        $showArray = $data;
        echo "使用者:" . $showArray['userId'] . "<br>";
        echo "金錢餘額:" . $showArray['money'];
        ?>
        <form action="insertMoney" name="reg" method="post" class="form" role="form">
            <input type="number" name="money" min="0"></br>
            <label class="radio-inline">
                <input type="radio" name="addOrCut" value="1" />
                取款
            </label>
            <label class="radio-inline">
                <input type="radio" name="addOrCut" value="0" />
                存款
            </label>
            <input type="hidden" name="userId" value="<?php echo $showArray['userId']; ?>">
            <button onClick="check()" type="button">送出</button>
        </form>
        <?php echo '<a href="/Payment/Home/showDetails?userId=' . $showArray['userId'] . '";>帳目明細</a>'; ?>
    </body>
</html>