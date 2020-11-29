<?php

require_once 'UserManager.php';

$userManager = new UserManager();

$rezult = null;

if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password-second']) && isset($_POST['name']) && isset($_POST['email'])) {

    $key_public = file_get_contents($_FILES['user_file']['tmp_name']);

    if($_POST['password'] !== $_POST['password-second']) {
        $rezult = 'password';
    }
    elseif (!$key_public) {
        $rezult = 'key';
    }
    else {
        $rezult = $userManager->createUser($_POST['login'],$_POST['password'],$_POST['name'],$_POST['email'], $key_public, 0);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/login.css">
    <title>Sing Up | File Sharing</title>
</head>
<body>

<div class="page page--login">
    <div class="login">
        <div class="login__container">
            <div class="login__logo">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                     width="470.000000pt" height="463.000000pt" viewBox="0 0 470.000000 463.000000"
                     preserveAspectRatio="xMidYMid meet">
                    <metadata>
                        Created by potrace 1.16, written by Peter Selinger 2001-2019
                    </metadata>
                    <g transform="translate(0.000000,463.000000) scale(0.100000,-0.100000)"
                       fill="#000000" stroke="none">
                        <path d="M1967 4275 l-337 -225 0 -278 c0 -297 1 -302 50 -302 48 0 50 9 50
232 0 114 3 208 7 208 4 0 124 -77 265 -172 l258 -171 0 -254 0 -253 -42 26
c-24 15 -90 58 -146 96 -80 54 -109 68 -128 64 -28 -7 -47 -40 -39 -66 6 -19
371 -268 405 -277 22 -5 406 250 415 275 8 28 -10 60 -39 68 -19 4 -53 -14
-158 -83 -73 -49 -139 -93 -145 -97 -10 -6 -13 46 -13 247 l0 254 258 171
c141 95 261 172 265 172 4 0 7 -94 7 -208 0 -224 2 -232 51 -232 55 0 59 18
59 298 0 159 -4 261 -11 273 -11 21 -662 459 -682 459 -7 0 -164 -101 -350
-225z m642 -90 c132 -88 241 -162 241 -165 0 -7 -525 -354 -535 -354 -10 0
-535 347 -534 354 0 3 120 85 266 182 l267 177 27 -17 c15 -9 135 -89 268
-177z"/>
                        <path d="M1625 3285 c-192 -141 -354 -264 -359 -275 -12 -27 17 -70 47 -70 14
0 159 99 378 258 288 211 355 263 357 284 4 30 -21 58 -51 58 -13 0 -172 -110
-372 -255z"/>
                        <path d="M2596 3524 c-19 -19 -20 -44 -3 -66 27 -35 702 -518 724 -518 30 0
59 44 47 70 -13 29 -704 530 -731 530 -12 0 -29 -7 -37 -16z"/>
                        <path d="M490 2904 c-179 -119 -331 -223 -338 -232 -18 -23 -18 -681 1 -704
15 -19 645 -439 667 -445 14 -4 355 212 403 254 9 9 17 26 17 38 0 24 -28 55
-50 55 -8 0 -75 -40 -149 -89 -75 -48 -142 -91 -148 -95 -10 -6 -13 46 -13
246 l0 253 256 170 c141 94 260 172 265 173 5 2 9 -85 9 -201 0 -185 2 -205
18 -220 25 -23 69 -22 82 2 12 23 14 539 2 557 -11 17 -671 454 -685 454 -7 0
-158 -97 -337 -216z m629 -99 c132 -88 241 -163 241 -166 0 -3 -120 -86 -266
-183 l-266 -178 -270 180 -270 180 268 180 c269 180 269 180 295 163 15 -9
135 -88 268 -176z m-595 -454 l256 -171 0 -250 c0 -138 -2 -250 -5 -250 -3 0
-124 79 -270 177 l-265 176 0 250 c0 211 2 248 14 244 8 -3 130 -83 270 -176z"/>
                        <path d="M3474 2910 c-175 -117 -329 -222 -341 -233 -23 -20 -23 -23 -23 -288
0 -290 2 -299 55 -299 52 0 55 15 55 237 0 115 4 203 9 201 5 -1 124 -79 265
-173 l256 -170 0 -254 0 -253 -22 14 c-190 124 -278 178 -290 178 -23 0 -50
-36 -46 -62 2 -17 47 -53 183 -145 99 -67 193 -127 208 -134 27 -11 41 -3 367
215 l340 226 0 350 0 350 -332 221 c-183 122 -340 224 -349 226 -9 3 -148 -83
-335 -207z m598 -452 l-270 -180 -266 178 c-146 97 -266 180 -266 183 0 3 120
86 267 183 l266 176 270 -180 269 -180 -270 -180z m318 -176 l0 -249 -265
-176 -265 -177 0 253 0 254 258 171 c141 95 260 172 265 172 4 0 7 -112 7
-248z"/>
                        <path d="M1105 2136 c-10 -15 -13 -31 -8 -44 10 -26 704 -532 730 -532 27 0
55 34 51 61 -4 30 -698 539 -734 539 -14 0 -30 -10 -39 -24z"/>
                        <path d="M3109 1902 c-291 -212 -355 -262 -357 -284 -4 -30 21 -58 51 -58 26
0 718 502 731 530 12 27 -17 70 -47 70 -15 0 -158 -98 -378 -258z"/>
                        <path d="M1968 1515 l-338 -225 0 -350 0 -350 332 -221 c183 -122 340 -224
349 -226 20 -5 673 427 688 456 12 22 16 647 5 676 -7 17 -655 455 -684 462
-8 2 -167 -98 -352 -222z m641 -90 c132 -88 241 -163 241 -166 0 -6 -526 -359
-535 -359 -6 0 -514 337 -529 350 -4 5 113 89 260 188 269 180 269 180 295
163 15 -9 135 -88 268 -176z m-607 -447 l258 -171 0 -254 c0 -201 -3 -253 -12
-247 -7 4 -127 83 -265 176 l-253 168 0 250 c0 138 3 250 7 250 4 0 124 -77
265 -172z m898 -78 l0 -250 -252 -168 c-139 -93 -259 -172 -265 -176 -10 -6
-13 46 -13 247 l0 254 258 171 c141 95 260 172 265 172 4 0 7 -112 7 -250z"/>
                    </g>
                </svg>
            </div>

            <form method="post" action="#" class="login__form" enctype="multipart/form-data">
                <input type="text" name="login" placeholder="Login" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password-second" placeholder="Repeat password" required>

                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>


                <a class="header__nav-link j-save-keys" href="#">Save Keys</a>
                <input type="file" name="user_file" required>

                <input type="submit" value="Sing up">
            </form>

            <?php
            if($rezult === true) {
                echo '<div style="color: green">Account was been created</div>';
            }
            else if($rezult === null) {

            }
            else if($rezult === -1) {
                echo '<div style="color: red">Please, change Login</div>';
            }
            else if($rezult === 'password') {
                echo '<div style="color: red">Passwords do not match</div>';
            }
            else if($rezult === 'key') {
                echo '<div style="color: red">File is empty</div>';
            }
            ?>

            <div class="login__separator">OR</div>

            <a class="login__singup" href="login.php">Login</a>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>