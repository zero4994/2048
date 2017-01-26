<?php
$gameTable = array([0,0,0,0],[0,0,0,0],[0,0,0,0],[0,0,0,0]);
//$M = rand(1,100000);

function fillTable ($gameTable){
    for ($row=0; $row < count($gameTable); $row++) {
        for ($column=0; $column<count($gameTable[$row]); $column++){
            $multiple = true;
            while($multiple){
                $gameTable[$row][$column] = rand(0,/*2048*/16);
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
    return $gameTable;
}//sortZeros

function sumCell ($gameTable, $initialCondition, $finalCondition, $operand, $direction ) {
    for($row=0; $row<count($gameTable); $row++) {
        if("right" == $direction){
            for($column=$initialCondition; $column>=$finalCondition; $column+=$operand){
                if($gameTable[$row][$column] == $gameTable[$row][$column-1]) {
                    $gameTable[$row][$column] +=  $gameTable[$row][$column-1];
                    $gameTable[$row][$column-1] = 0;
                    $column+=$operand;
                }//if
            }//for
        } else if("left" == $direction){
            for($column=$initialCondition; $column<$finalCondition; $column++){
                if($gameTable[$row][$column] == $gameTable[$row][$column+1]) {
                    $gameTable[$row][$column] +=  $gameTable[$row][$column+1];
                    $gameTable[$row][$column+=$operand] = 0;
                    $column++;
                }//if
            }//for
        }//else if
    }//for
    return $gameTable;
}//sumCell

function sortZeroUp ($gameTable) {
    for($column=0; $column<4; $column++) {
        $temp = array(0,0,0,0);
        $counter = 0;
        for($row=0; $row<4; $row++){
            if($gameTable[$row][$column]>0) {
                $temp[$counter] = $gameTable[$row][$column];
                $counter ++;
            }//if
        }//for

        if($counter!=0){
            for($i=0; $i<count($temp); $i++){
                $gameTable[$i][$column] = $temp[$i];
            }
        }//if
    }//for
    return $gameTable;
}//

function sumCellUp ($gameTable){
    for($column=0; $column<4; $column++) {
        for($row=0; $row<4; $row++){
            if(($row+1<4) && ($gameTable[$row][$column] == $gameTable[$row+1][$column])) {
                $gameTable[$row][$column] +=  $gameTable[$row+1][$column];
                $gameTable[$row+1][$column] = 0;
                $row++;
            }//if
        }//for
    }//for
    return $gameTable;
}//

function sortZeroDown ($gameTable){
    for($column=3; $column>=0; $column--) {
        $temp = array(0,0,0,0);
        $counter = 3;
        for($row=3; $row>=0; $row--){
            if($gameTable[$row][$column]>0) {
                $temp[$counter] = $gameTable[$row][$column];
                $counter--;
            }//if
        }//for

        if($counter!=3){
            for($i=3; $i>=0; $i--){
                $gameTable[$i][$column] = $temp[$i];
            }
        }//if
    }//for
    return $gameTable;
}//

function sumCellDown ($gameTable){
    for($column=3; $column>=0; $column--) {
        for($row=3; $row>=0; $row--){
            if(($row-1>=0) && ($gameTable[$row][$column] == $gameTable[$row-1][$column])) {
                $gameTable[$row][$column] +=  $gameTable[$row-1][$column];
                $gameTable[$row-1][$column] = 0;
                $row--;
            }//if
        }//for
    }//for
    return $gameTable;
}//

$gameTable = fillTable($gameTable);
print_matrix($gameTable);
echo "<br><br>";
$flag =0;
/*while ($flag<3){
    $random = rand(1,3);
    if($random == 1) { //Right
        echo "<br><br>Right<br>";
        $gameTable = sortZeros($gameTable, 3,0,-1, "right");
        //print_matrix($gameTable);
        //echo "<br><br>";
        $gameTable = sumCell($gameTable,3,0,-1, "right");
        //print_matrix($gameTable);
        //echo "<br><br>";
        $gameTable = sortZeros($gameTable, 3,0,-1, "right");
        print_matrix($gameTable);
    } else if ($random == 2){ //Left
        echo "<br><br>Left<br>";
        $gameTable = sortZeros($gameTable, 0,4,1, "left");
        //print_matrix($gameTable);
        //echo "<br><br>";
        $gameTable = sumCell($gameTable,0,4,1, "left");
        $gameTable = sortZeros($gameTable, 0,4,1, "left");
        print_matrix($gameTable);
    } else if($random == 3){ //Up
        echo "<br><br>Up<br>";
        $gameTable = sortZeroUp($gameTable);
        //print_matrix($gameTable);
        $gameTable = sumCellUp($gameTable);
        /*echo "<br><br>";
        print_matrix($gameTable);
        echo "<br><br>";* /
        $gameTable = sortZeroUp($gameTable);
        print_matrix($gameTable);
    }//else if
    $flag++;
}//while*/

$gameTable = sortZeroDown($gameTable);
print_matrix($gameTable);
echo "<br><br>";
$gameTable = sumCellDown($gameTable);
print_matrix($gameTable);
echo "<br><br>";
$gameTable = sortZeroDown($gameTable);
print_matrix($gameTable);