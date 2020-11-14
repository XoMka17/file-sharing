<?php include "header.php"; ?>

<?php
require_once 'BlockChain.php';
$BlockChain = new BlockChain();

$blocks = $BlockChain->getBlocks();

if($blocks) {
    echo '<table>';

    echo '<thead>
        <th>#</th>
        <th>Timestamp</th>
        <th>User</th>
        <th>Previous Hash</th>
        <th>Hash</th>
        <th>Action</th>
</thead>';

    echo '<tbody>';

    $background_colors = ['#ffffff','#eeeeeeaa'];
    $lastID = '';
    $is_changed_block = true;
    $files_counter = 0;

    for($i = count($blocks) - 1; $i >= 0; $i--) {
        if($lastID != $BlockChain->getID($blocks[$i]->data)) {
            $current_background_color = $background_colors[$files_counter%2];
            $is_changed_block = true;
            $files_counter++;
        }

        echo '<tr style="background: ' . $current_background_color . '">';

        echo '<td>' . $blocks[$i]->index . '</td>';
        echo '<td>' . date('H:i:s d-m-Y ',$blocks[$i]->timestamp) . '</td>';
        echo '<td>' . $blocks[$i]->user . '</td>';

        // !Todo Нужна дата на час вперёд (main.js line 102)
        echo '<td>' . $blocks[$i]->previousHash . '</td>';
//        echo '<td>' . $blocks[$i]->data . '</td>';
        echo '<td>' . $blocks[$i]->hash . '</td>';
        echo '<td>';
        if($is_changed_block && $i != 0) {
            echo '<a href="./get.php?block=' . $i . '">Download</a>';
        }
        echo '</td>';

        $lastID = $BlockChain->getID($blocks[$i]->data);
        $is_changed_block = false;
        echo '</tr>';
    }
    echo '</tbody>';
}

?>

</body>
</html>
