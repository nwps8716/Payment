# Payment

<font color="red">FOR UPDATE:</font><br>
例: $sql = "SELECT `money` FROM `userdata` WHERE `userid` = :userId FOR UPDATE";
當有一個使用者鎖定後，另一方的操作，會等到前一方的使用者commit後才執行。<br>

<font color="red">SELECT ... LOCK IN SHARE MODE:</font><br>
例: $sql = "SELECT `money` FROM `userdata` WHERE `userid` = :userId LOCK IN SHARE MODE ";
與FOR UPDATE不同的是另一方的操作還是可以找尋到userdata的資料，但是要等前一位使用者commit才可執行update。<br>

<font color="red">LOCK TABLES:</font><br>
整張資料表會被鎖死，可能導致其它使用者無法使用資料表。
執行SQL語句 鎖掉stat_num表
$sql = "LOCK TABLES stat_num WRITE";  //表的WRITE鎖定，阻塞其他所有mysql查詢進程
$DatabaseHandler->exeCute($sql);<br>

執行更新或寫入操作<br>
$sql = "UPDATE stat_num SET `correct_num`=`correct_num`+1 WHERE stat_date='{$cur_date}'";
$DatabaseHandler->exeCute($sql);<br>

當前請求的所有寫操作做完後，執行解鎖sql語句<br>
$sql = "UNLOCK TABLES";
$DatabaseHandler->exeCute($sql);<br>

<font color="red">樂觀鎖:</font><br>
新增一個version版本欄位，SELECT時讓version版本+1，在update時判斷是否是新的version版本，如果是才能新增。<br>


單元測試部分是在myProject資料夾底下。<br>
https://testweb-lid-chen.c9users.io/Payment/coverage/myProject/index.html
