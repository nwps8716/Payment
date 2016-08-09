<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Show details</title>
    </head>
    <style>
        table {
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid black;
        }
    </style>

    <body>
        <?php 
        $showArray = $data;
        ?>

        <table class="table table-bordered">
            <tr class="info">
                <td>使用者帳戶</td>
                <td>交易方式</td>
                <td>交易金額</td>
            </tr>
            <?php for ($i = 0 ; $i < $showArray["num"] ; $i++) { ?>
            <tr>
                <td><?php echo $showArray["row"][$i]["balance"]; ?></td> 
                <td>
                    <?php 
                    if ($showArray["row"][$i]["AddorCut"] == 0) {
                        echo "入款";
                    } else {
                        echo "出款";
                    }
                    ?>
                </td> 
                <td><?php echo $showArray["row"][$i]["money"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
