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
                    for($i = 0; $i <= 3; $i++){
                        $values[$i] == $board[$row][$i] 
                }
                    for($c = 0; $c <= 3; $c++){
                        
                    }
            }
        }
    }
    return $board;
}
}


solveSudoku($sudoku);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudoku</title>
</head>
<body>

<table>
    <?php foreach ($sudoku as $row): ?>
        <tr>
            <?php foreach ($row as $cell): ?>
                <td><?php echo $cell; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    
</body>
</html>