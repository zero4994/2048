<!DOCTYPE html>
<html>
<head>
    <title>2048</title>
</head>
<body>
<p>
    <form action="Index.php" method="GET">
        <input type="submit" name="submit" value="Return">
    </form>
    <?php
    $gameTable = array([0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0]);
    function fillTable ($gameTable){
        for ($row=0; $row < count($gameTable); $row++) {
            for ($column=0; $column<count($gameTable[$row]); $column++){
                $multiple = true;
                while($multiple){
                    $gameTable[$row][$column] = rand(0,2048);
                    if(($gameTable[$row][$column] & ($gameTable[$row][$column] -1))==0){
                        if ($gameTable[$row][$column] == 1){
                            $multiple = true;
                        } else {
                            $multiple = false;
                        }//else
                    } else {
                        $multiple = true;
                    }//else
                }//while
            }//for
        }//for
        return $gameTable;
    }//fillTable

    function print_matrix ($gameTable){
        foreach($gameTable as $row) {
            foreach ($row as $column) {
                echo $column."&emsp;&emsp;";
            }//foreach
            echo "<br>";
        }//foreach
    }//print_table

    function sortZeros ($gameTable, $initialCondition, $finalCondition, $operand, $direction){
        if ("up" == $direction || "down" == $direction){
            for($column=0; $column<count($gameTable); $column++) {
                $temp = array(0,0,0,0);
                $counter = $initialCondition;

                if("up" == $direction){
                    for($row=$initialCondition; $row<$finalCondition; $row+=$operand){
                        if($gameTable[$row][$column]>0) {
                            $temp[$counter] = $gameTable[$row][$column];
                            $counter+=$operand;
                        }//if
                    }//for

                    if($counter!=$initialCondition){
                        for($i=$initialCondition; $i<$finalCondition; $i+=$operand){
                            $gameTable[$i][$column] = $temp[$i];
                        }//for
                    }//if
                } else if ("down" == $direction){
                    for($row=$initialCondition; $row>=$finalCondition; $row+=$operand){
                        if($gameTable[$row][$column]>0) {
                            $temp[$counter] = $gameTable[$row][$column];
                            $counter+=$operand;
                        }//if
                    }//for

                    if($counter!=$initialCondition){
                        for($i=$initialCondition; $i>=$finalCondition; $i+=$operand){
                            $gameTable[$i][$column] = $temp[$i];
                        }//for
                    }//if
                }//else if
            }//for
        } else {
            for($row=0; $row<count($gameTable); $row++) {
                $temp = array(0,0,0,0);
                $counter = $initialCondition;
                if("right" == $direction){
                    for($column=$initialCondition; $column>=$finalCondition; $column+=$operand){
                        if($gameTable[$row][$column]>0) {
                            $temp[$counter] = $gameTable[$row][$column];
                            $counter += $operand;
                        }//if
                    }//for
                } else if("left" == $direction){
                    for($column=$initialCondition; $column<$finalCondition; $column+=$operand){
                        if($gameTable[$row][$column]>0) {
                            $temp[$counter] = $gameTable[$row][$column];
                            $counter += $operand;
                        }//if
                    }//for
                }//else

                if($counter!=$initialCondition){
                    $gameTable[$row] = $temp;
                }//if
            }//for
        }//else
        return $gameTable;
    }//sortZeros

    function sumCell ($gameTable, $initialCondition, $finalCondition, $operand, $direction ) {
        if("up" == $direction || "down" == $direction){
            for($column=0; $column<count($gameTable); $column++) {
                if ("up" == $direction) {
                    for ($row = 0; $row < 4; $row += 1) {
                        if (($row + $operand < $finalCondition) && ($gameTable[$row][$column] == $gameTable[$row + 1][$column])) {
                            if($gameTable[$row][$column] + $gameTable[$row + 1][$column] <= 2048){
                                $gameTable[$row][$column] += $gameTable[$row + 1][$column];
                            }//if
                            $gameTable[$row + 1][$column] = 0;
                            $row+=$operand;
                        }//if
                    }//for
                } else if ("down" == $direction) {
                    for ($row = $initialCondition; $row >= $finalCondition; $row += $operand) {
                        if (($row + $operand >= $finalCondition) && ($gameTable[$row][$column] == $gameTable[$row - 1][$column])) {
                            if($gameTable[$row][$column] + $gameTable[$row - 1][$column] <= 2048 ){
                                $gameTable[$row][$column] += $gameTable[$row - 1][$column];
                            }//if
                            $gameTable[$row - 1][$column] = 0;
                            $row+=$operand;
                        }//if
                    }//for
                }//if
            }//for
        } else {
            for($row=0; $row<count($gameTable); $row++) {
                if("right" == $direction){
                    for($column=$initialCondition; $column>=$finalCondition; $column+=$operand){
                        if(($column+$operand>=$finalCondition) && ($gameTable[$row][$column] == $gameTable[$row][$column-1])) {
                            if($gameTable[$row][$column] +  $gameTable[$row][$column-1] <= 2048){
                                $gameTable[$row][$column] +=  $gameTable[$row][$column-1];
                            }//if
                            $gameTable[$row][$column-1] = 0;
                            $column+=$operand;
                        }//if
                    }//for
                } else if("left" == $direction){
                    for($column=$initialCondition; $column<$finalCondition; $column++){
                        if(($column+$operand<$finalCondition) && ($gameTable[$row][$column] == $gameTable[$row][$column+1])) {
                            if($gameTable[$row][$column] + $gameTable[$row][$column+1] <= 2048) {
                                $gameTable[$row][$column] +=  $gameTable[$row][$column+1];
                            }//if
                            $gameTable[$row][$column+=$operand] = 0;
                            $column+=$operand;
                        }//if
                    }//for
                }//else if
            }//for
        }//else
        return $gameTable;
    }//sumCell

    function addCell($gameTable){
        $bFlag=false;
        for ($row=0; $row<count($gameTable); $row++){
            for($column=0; $column<count($gameTable[$row]); $column++){
                if($gameTable[$row][$column] == 0){
                    $gameTable[$row][$column] = 2;
                    $bFlag = true;
                    break;
                }//if
            }//for
            if($bFlag){
                break;
            }//if
        }//for
        return $gameTable;
    }//addCell

    if(isset($_REQUEST['submit'])){
        $m = (int)$_REQUEST['m'];
        echo $m."<br>";
        if (is_int($m) && $m >=1 && $m<=100000) {
            $gameTable = fillTable($gameTable);
            echo "Original<br>";
            print_matrix($gameTable);
            echo "<br><br>";
            $flag =0;
        } else {
            echo "Value not between 1>=M<=10^5 or float";
        }//else
    }//if
    /*while ($flag<5){
        $random = rand(1,4);
        $word;
        if($random == 1) { //Right
            echo "<br><br>Right<br>";
            $word = "right";
        } else if ($random == 2){ //Left
            echo "<br><br>Left<br>";
            $word = "left";
        } else if($random == 3){ //Up
            echo "<br><br>Up<br>";
            $word = "up";
        } else if ($random == 4){//Down
            echo "<br><br>Down<br>";
            $word = "down";
        }//else if

        if ("right" == $word || "down" == $word){
            $gameTable = sortZeros($gameTable, 3,0,-1, $word);
            $gameTable = sumCell($gameTable,3,0,-1, $word);
            $gameTable = sortZeros($gameTable, 3,0,-1, $word);
        } else {
            $gameTable = sortZeros($gameTable, 0,4,1,$word);
            $gameTable = sumCell($gameTable, 0,4,1, $word);
            $gameTable = sortZeros($gameTable,0,4,1, $word);
        }//else
        $gameTable = addCell($gameTable);
        print_matrix($gameTable);
        $flag++;
    }//while*/
    ?>
</p>
</body>
</html>