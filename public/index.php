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
        <th>File Name</th>
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
        echo '<td>' . $blocks[$i]->fileName . '</td>';

        // !Todo Нужна дата на час вперёд (main.js line 102)
        echo '<td>' . $blocks[$i]->previousHash . '</td>';
//        echo '<td>' . $blocks[$i]->data . '</td>';
        echo '<td>' . $blocks[$i]->hash . '</td>';
        echo '<td>';
        if($is_changed_block && $i != 0) {
            echo '<a href="./get.php?block=' . $i . '" title="download file">
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve" width="20px">
	<g>
		<path style="fill:#030104;" d="M18,13c0,1.656-1.344,3-3,3h-4c-1.656,0-3-1.344-3-3V3c0-1.657,1.344-3,3-3h4c1.656,0,3,1.343,3,3 V13z"/>
		<path style="fill:#030104;" d="M15.209,19.02c-2.205,2.206-2.178,2.2-4.379,0l-6.568-6.568C3.055,11.241,3.332,11,4.742,11h16.561 c1.273,0,1.684,0.241,0.476,1.451L15.209,19.02z"/>
		<path style="fill:#030104;" d="M24,19v4c0,0.551-0.448,1-1,1H3c-0.552,0-1-0.449-1-1v-4H0v4c0,1.656,1.344,3,3,3h20 c1.656,0,3-1.344,3-3v-4H24z"/>
	</g>
</svg>
</a>';
        }
        echo '</td>';

        $lastID = $BlockChain->getID($blocks[$i]->data);
        $is_changed_block = false;
        echo '</tr>';
    }
    echo '</tbody>';
}

?>

<div class="popup" id="add-file">
    <div class="popup__container">
        <div class="popup__close j-close"></div>

        <div class="popup__content">
            <div class="popup_title">
                Choose file
            </div>

            <div class="popup__upload">
                <form enctype="multipart/form-data" action="add.php" method="POST">
                    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
<!--                    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />-->
                    <!-- Название элемента input определяет имя в массиве $_FILES -->
                    <input name="userfile" type="file" />
                    <input type="submit" value="Send file" />
                </form>
            </div>
        </div>
    </div>

    <div class="popup__bg j-close"></div>
</div>

<script src="./js/jquery.js"></script>

<script src="./js/popup.js"></script>
<script src="./js/add_file.js"></script>
</body>
</html>
