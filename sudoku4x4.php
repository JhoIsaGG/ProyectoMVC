<?php 

$sudoku = [
    [1, 0, 3, 0],
    [0, 0, 0, 2],
    [2, 1, 0, 0],
    [4, 0, 2, 0]
];

function solveSudoku($board)
{
    for ($row = 0; $row <= 3; $row++){
        for($column = 0; $column <= 3; $column++){
            if(($board[$row][$column]) == 0){
                for($try = 0; $try <= 3; $try++){
                    $number = $try + 1;
                    if($board[$row][$column] == $number){
                        $board[$row][$column] = $number;
                        return break;
                    }
                }
            }
        }
    }
    return $board;
}


echo $sudoku[0][0];