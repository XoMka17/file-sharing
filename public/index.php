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
        echo '<td style="min-width: 70px;">';
        if($i != 0) {
            echo '<a href="./get.php?block=' . $i . '" title="Download file">
<svg width="20px" height="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#2196F3;" d="M243.968,378.528c3.04,3.488,7.424,5.472,12.032,5.472s8.992-2.016,12.032-5.472l112-128 c4.16-4.704,5.12-11.424,2.528-17.152S374.272,224,368,224h-64V16c0-8.832-7.168-16-16-16h-64c-8.832,0-16,7.168-16,16v208h-64 c-6.272,0-11.968,3.68-14.56,9.376c-2.624,5.728-1.6,12.416,2.528,17.152L243.968,378.528z"/><path style="fill:#607D8B;" d="M432,352v96H80v-96H16v128c0,17.696,14.336,32,32,32h416c17.696,0,32-14.304,32-32V352H432z"/></svg>
</a>';
            echo '<span title="Check signature" class="j-check-signature" data-index="' . $i . '" data-userID="' . $blocks[$i]->user . '" data-signature="' . $blocks[$i]->signature . '">
<svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#ffc107"/><path d="m277.332031 384c0 11.78125-9.550781 21.332031-21.332031 21.332031s-21.332031-9.550781-21.332031-21.332031 9.550781-21.332031 21.332031-21.332031 21.332031 9.550781 21.332031 21.332031zm0 0" fill="#eceff1"/><path d="m289.769531 269.695312c-7.550781 3.476563-12.4375 11.09375-12.4375 19.394532v9.578125c0 11.773437-9.535156 21.332031-21.332031 21.332031s-21.332031-9.558594-21.332031-21.332031v-9.578125c0-24.898438 14.632812-47.722656 37.226562-58.15625 21.738281-10.003906 37.4375-36.566406 37.4375-49.601563 0-29.394531-23.914062-53.332031-53.332031-53.332031s-53.332031 23.9375-53.332031 53.332031c0 11.777344-9.539063 21.335938-21.335938 21.335938s-21.332031-9.558594-21.332031-21.335938c0-52.925781 43.070312-96 96-96s96 43.074219 96 96c0 28.824219-25.003906 71.191407-62.230469 88.363281zm0 0" fill="#fafafa"/></svg>
</span>';
            echo '<span title="Information" class="j-check-info" data-index="' . $i . '" data-signature="' . $blocks[$i]->signature . '">
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#738C96;" d="M512,256c0,68.387-26.635,132.674-74.985,181.025S324.377,512,256,512h-0.29 c-68.277-0.08-132.454-26.695-180.735-74.975C26.625,388.674,0,324.387,0,256c0-68.377,26.625-132.664,74.975-181.015 C123.256,26.705,187.433,0.08,255.71,0H256c68.377,0,132.664,26.635,181.015,74.985S512,187.623,512,256z M512,256c0,68.387-26.635,132.674-74.985,181.025S324.377,512,256,512h-0.29V0H256 c68.377,0,132.664,26.635,181.015,74.985S512,187.623,512,256z"/><g><path style="fill:#fafafa;" d="M313.169,146.891c0,31.524-25.645,57.169-57.169,57.169h-0.29 	c-31.404-0.16-56.889-25.745-56.889-57.169s25.485-57.009,56.889-57.169H256C287.524,89.722,313.169,115.367,313.169,146.891z M256,204.06h-0.29V89.722H256c31.524,0,57.169,25.645,57.169,57.169S287.524,204.06,256,204.06z"/><path style="fill:#fafafa;" d="M313.169,288.184v75.635c0,31.524-25.645,57.169-57.169,57.169h-0.29 c-31.404-0.16-56.889-25.745-56.889-57.169v-75.635c0-31.424,25.485-57.019,56.889-57.179H256 C287.524,231.005,313.169,256.66,313.169,288.184z M313.169,288.184v75.635c0,31.524-25.645,57.169-57.169,57.169h-0.29V231.005H256 C287.524,231.005,313.169,256.66,313.169,288.184z"/></g></svg>
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
                Complete next steps:
            </div>

            <div class="popup__upload">
                <form id="form-upload" class="file-form j-add-form" name="form_upload" enctype="multipart/form-data" action="add.php" method="POST">
                    <div class="file-form__row file-form__upload-file j-user-file-container">
                        <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                        <input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
                        <div class="file-form__label">
                            1. Choose file
                        </div>
                        <input id="user-file" class="file-form__input j-user-file" name="user_file" type="file" />
                    </div>

                    <div class="file-form__row file-form__upload-key j-user-key-container">
                        <div class="file-form__label">
                            2. Choose your private key
                        </div>
                        <input id="user-key" class="file-form__input j-user-key" name="user_key" type="file" />
                    </div>

                    <input class="file-form__submit j-submit-add" type="submit" value="Send file" />
                </form>
            </div>
        </div>
    </div>

    <div class="popup__bg j-close"></div>
</div>


<div class="popup" id="info-popup">
    <div class="popup__container">
        <div class="popup__close j-close"></div>

        <div class="popup__content">
            <div class="popup_title">
                Information about block # <span></span>
            </div>

        </div>
    </div>

    <div class="popup__bg j-close"></div>
</div>

<?php include "footer.php"; ?>