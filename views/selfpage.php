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
        echo "使用者:" . $showArray[0]['userid'] . "<br>";
        echo "金錢餘額:" . $showArray[0]['money'];
        ?>
        <form action="selfpage" name="reg" method="post" class="form" role="form">
            <input type="number" name="money" min="0"></br>
            <label class="radio-inline">
                <input type="radio" name="addOrCut" value="1" />
                取款
            </label>
            <label class="radio-inline">
                <input type="radio" name="addOrCut" value="0" />
                存款
            </label>
            <input type="hidden" name="userId" value="<?php echo $showArray[0]['userid']; ?>">
            <input type="hidden" name="oriMoney" value="<?php echo $showArray[0]['money']; ?>">
            <button onClick="check()" type="button">送出</button>
        </form>
        <?php echo '<a href="/Payment/Home/show?userId=' . $showArray[0]['userid'] . '";>帳目明細</a>'; ?>
    </body>
</html>