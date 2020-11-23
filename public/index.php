<?php include "header.php"; ?>

<?php
require_once 'UserManager.php';
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

    $UserManager = new UserManager();
    $background_colors = ['#ffffff','#eeeeeeaa'];

    for($i = count($blocks) - 1; $i >= 0; $i--) {

        echo '<tr style="background: ' . $background_colors[$i%2] . '">';

        echo '<td>' . $blocks[$i]->index . '</td>';
        echo '<td>' . date('H:i:s d-m-Y ',$blocks[$i]->timestamp) . '</td>';

        if(is_numeric($blocks[$i]->user)) {

            if($blocks[$i]->user == 0) {
                echo '<td>genesis</td>';
            }
            else {
                echo '<td>' . $UserManager->getUserByID($blocks[$i]->user)['name'] . '</td>';
            }
        }

        echo '<td>' . $blocks[$i]->fileName . '</td>';
//        echo '<td>' . $blocks[$i]->signature . '</td>';

        // !Todo Нужна дата на час вперёд (main.js line 102)
        echo '<td>' . $blocks[$i]->previousHash . '</td>';
//        echo '<td>' . $blocks[$i]->data . '</td>';
        echo '<td>' . $blocks[$i]->hash . '</td>';
        echo '<td>';
        if($i != 0) {
            echo '<a href="./get.php?block=' . $i . '" title="download file">
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve" width="20px">
	<g>
		<path style="fill:#030104;" d="M18,13c0,1.656-1.344,3-3,3h-4c-1.656,0-3-1.344-3-3V3c0-1.657,1.344-3,3-3h4c1.656,0,3,1.343,3,3 V13z"/>
		<path style="fill:#030104;" d="M15.209,19.02c-2.205,2.206-2.178,2.2-4.379,0l-6.568-6.568C3.055,11.241,3.332,11,4.742,11h16.561 c1.273,0,1.684,0.241,0.476,1.451L15.209,19.02z"/>
		<path style="fill:#030104;" d="M24,19v4c0,0.551-0.448,1-1,1H3c-0.552,0-1-0.449-1-1v-4H0v4c0,1.656,1.344,3,3,3h20 c1.656,0,3-1.344,3-3v-4H24z"/>
	</g>
</svg>
</a>';
            echo '<span title="Check signature" class="j-check-signature" data-index="' . $i . ' " data-userID="' . $blocks[$i]->user . ' " data-signature="' . $blocks[$i]->signature . ' ">
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve" width="20px">
	<g>
		<path style="fill:#030104;" d="M18,13c0,1.656-1.344,3-3,3h-4c-1.656,0-3-1.344-3-3V3c0-1.657,1.344-3,3-3h4c1.656,0,3,1.343,3,3 V13z"/>
		<path style="fill:#030104;" d="M15.209,19.02c-2.205,2.206-2.178,2.2-4.379,0l-6.568-6.568C3.055,11.241,3.332,11,4.742,11h16.561 c1.273,0,1.684,0.241,0.476,1.451L15.209,19.02z"/>
		<path style="fill:#030104;" d="M24,19v4c0,0.551-0.448,1-1,1H3c-0.552,0-1-0.449-1-1v-4H0v4c0,1.656,1.344,3,3,3h20 c1.656,0,3-1.344,3-3v-4H24z"/>
	</g>
</svg>
</span>';
        }
        echo '</td>';
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
                <form id="form-upload" class="file-form j-add-form" name="form_upload" enctype="multipart/form-data" action="add.php" method="POST">
                    <div class="file-form__upload-file j-user-file-container">
                        <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                        <!--                    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />-->
                        <!-- Название элемента input определяет имя в массиве $_FILES -->
                        <input id="user-file" class="file-form__input j-user-file" name="user_file" type="file" />
                    </div>

                    <div class="file-form__upload-key j-user-key-container">
                        <input id="user-key" class="file-form__input j-user-key" name="user_key" type="file" />
                        <input class="file-form__submit j-submit-add" type="submit" value="Send file" />
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="popup__bg j-close"></div>
</div>

<script src="./js/jquery.js"></script>

<script src="./js/popup.js"></script>

<script src="./js/digital_signature.js"></script>
<script src="./js/add_file.js"></script>
<script src="./js/check_signature.js"></script>

</body>
</html>
