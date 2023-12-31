<?
error_reporting(E_ALL);
ini_set("display_error", "on");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$login = "root";
$pass = "";
$database = "coursework";
$link = mysqli_connect($host, $login, $pass, $database);

$allComments = "SELECT * FROM comments"; //Значения из таблицы комментариев
$resltComment = mysqli_query($link, $allComments) or die(mysqli_error($link));
for ($mass = []; $row = mysqli_fetch_assoc($resltComment); $mass[] = $row)
    ;
function textValidation($date) //Валидация написанного текста в комментариях
{
    $date = trim($date);
    $date = stripslashes($date);
    $date = htmlspecialchars($date);
    $date = strtr($date, "+&=/", '   ');
    return $date;
}
;
$id = mysqli_real_escape_string($link, $_GET['id']); //Получение id статьи из гет запроса
$query = "SELECT * FROM article INNER JOIN comments ON article.id = comments.article_id";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$post = mysqli_fetch_assoc($res);

if (!empty($_POST) && isset($_POST)) {
    $query = "SELECT * FROM comments WHERE article_id=" . $id . "";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $post = mysqli_fetch_assoc($res);
    $nickComment = textValidation($_POST["nickComment"]);
    $textComment = textValidation($_POST["textComment"]);
    $date = date("Y-m-d");
    if ($textComment != '' && $nickComment != '') { //создание данных комментария при соблюдении условий
        $sql = "INSERT INTO comments (user_name, comments_text, date, article_id) VALUES (? , ? , ? , ? )";
        $command = $link->prepare($sql);
        $command->bind_param("ssss", $nickComment, $textComment, $date, $id);
        $command->execute();
        mysqli_close($link);
        // $add = "INSERT INTO comments SET user_name='$nickComment', comments_text='$textComment', date='$date' article_id='$id'";
        // mysqli_query($link, $add);
        header("location: indexArticle.php?id=$id");
        die();
    }
}
$allArticle = "SELECT * FROM article";
$resltAllArticle = mysqli_query($link, $allArticle) or die(mysqli_error($link));
for ($massArticle = []; $row = mysqli_fetch_assoc($resltAllArticle); $massArticle[] = $row)
    ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статья</title>
    <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../STYLE/Allstyle.css"><!--Общие стили -->
    <link rel="stylesheet" href="../STYLE/main.css"><!--Cтили главной  -->
    <link rel="stylesheet" href="../STYLE/Article.css"><!--Cтили главной  -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Начало header -->
    <nav class="navbar navbar-expand header">
        <div class="container-fluid headercontainer">
            <img src="../image/starHeader.png" alt="">
            <a class="navbar-brand" href="../index.php">Zodiac Sign.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webPage/indexBall.html">Предсказание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webPage/indexNews.php">Блог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webPage/indexAboutMe.php">Обо мне</a>
                    </li>

                </ul>
                <button class="btn disable" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 384 256" fill="none">
                        <path d="M24 24H360M24 128H360M24 232H360" stroke="#C9CBE5" stroke-width="48"
                            stroke-miterlimit="10" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Начало мобильного меню -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ">
            <ul class="navbar-nav mobilenavbar">
                <li class="nav-item border-top">
                    <a class="nav-link active" aria-current="page" href="../index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../webPage/indexBall.html">Предсказание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../webPage/indexNews.php">Блог</a>
                </li>
                <li class="nav-item border-bottom">
                    <a class="nav-link" href="../webPage/indexAboutMe.php">Обо мне</a>
                </li>
            </ul>
            <div id="contactBlock">
                <div id="contact">
                    <div class="blockContactSvg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="29" height="29"
                            viewBox="0 0 29 29" fill="none">
                            <a xlink:href="https://github.com/Lafy-qx">
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#C9CBE5"
                                    d="M14.4993 0C6.49191 0 0 6.65668 0 14.8679C0 21.4366 4.15369 27.0091 9.91614 28.9739C10.6419 29.1115 10.9059 28.6536 10.9059 28.2583C10.9059 27.9061 10.8932 26.9717 10.8869 25.7298C6.8533 26.629 6.00226 23.7364 6.00226 23.7364C5.34269 22.0191 4.39201 21.5624 4.39201 21.5624C3.07549 20.6406 4.49203 20.6585 4.49203 20.6585C5.94723 20.7641 6.71313 22.1902 6.71313 22.1902C8.00623 24.4622 10.1072 23.8046 10.933 23.4265C11.0642 22.4639 11.4398 21.8102 11.8536 21.4377C8.63419 21.0626 5.24937 19.7871 5.24937 14.0903C5.24937 12.4667 5.81413 11.1393 6.74138 10.0998C6.59304 9.72542 6.09446 8.21393 6.88378 6.16607C6.88378 6.16607 8.10104 5.76656 10.8717 7.69129C12.0276 7.36002 13.2682 7.19457 14.5015 7.18962C15.7329 7.19495 16.9739 7.36002 18.1313 7.69129C20.9001 5.76656 22.1155 6.16607 22.1155 6.16607C22.9067 8.21393 22.4084 9.72542 22.2597 10.0998C23.1892 11.1393 23.7499 12.4667 23.7499 14.0903C23.7499 19.8004 20.3602 21.0584 17.1301 21.4251C17.6498 21.8845 18.1138 22.7937 18.1138 24.1809C18.1138 26.1674 18.0964 27.7704 18.0964 28.2579C18.0964 28.6563 18.357 29.1195 19.0932 28.9719C24.8493 27.003 29 21.4347 29 14.8679C29 6.65668 22.5081 0 14.4993 0Z" />
                            </a>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="30" height="30"
                            viewBox="0 0 30 30" fill="none">
                            <a xlink:href="https://t.me/ka4an_qx">
                                <path fill="#C9CBE5"
                                    d="M14.5312 0C6.50391 0 0 6.50391 0 14.5312C0 22.5586 6.50391 29.0625 14.5312 29.0625C22.5586 29.0625 29.0625 22.5586 29.0625 14.5312C29.0625 6.50391 22.5586 0 14.5312 0ZM21.668 9.95508L19.2832 21.1934C19.1074 21.9902 18.6328 22.1836 17.9707 21.8086L14.3379 19.1309L12.5859 20.8184C12.3926 21.0117 12.2285 21.1758 11.8535 21.1758L12.1113 17.4785L18.8438 11.3965C19.1367 11.1387 18.7793 10.9922 18.3926 11.25L10.0723 16.4883L6.48633 15.3691C5.70703 15.123 5.68945 14.5898 6.65039 14.2148L20.6602 8.8125C21.3105 8.57812 21.8789 8.9707 21.668 9.95508Z" />
                            </a>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="29" height="29"
                            viewBox="0 0 29 29" fill="none">
                            <a xlink:href="https://vk.com/who_asexual">
                                <path fill="#C9CBE5"
                                    d="M14.5 0C6.49177 0 0 6.49177 0 14.5C0 22.5082 6.49177 29 14.5 29C22.5082 29 29 22.5082 29 14.5C29 6.49177 22.5082 0 14.5 0ZM20.0765 16.3593C20.0765 16.3593 21.3588 17.6251 21.6745 18.2126C21.6835 18.2247 21.6881 18.2368 21.6911 18.2428C21.8195 18.4588 21.8497 18.6265 21.7863 18.7518C21.6805 18.9603 21.318 19.063 21.1942 19.072H18.9285C18.7715 19.072 18.4422 19.0313 18.0434 18.7564C17.7368 18.5419 17.4347 18.1899 17.1402 17.8471C16.7007 17.3366 16.3201 16.8955 15.9364 16.8955C15.8877 16.8954 15.8392 16.9031 15.7929 16.9182C15.5029 17.0118 15.1314 17.4257 15.1314 18.5283C15.1314 18.8727 14.8595 19.0705 14.6677 19.0705H13.63C13.2766 19.0705 11.4354 18.9467 9.80411 17.2263C7.80734 15.1193 6.00995 10.8931 5.99484 10.8539C5.88156 10.5805 6.11568 10.434 6.37094 10.434H8.65922C8.96432 10.434 9.06401 10.6197 9.13349 10.7844C9.21505 10.9762 9.51411 11.739 10.005 12.5969C10.801 13.9955 11.2889 14.5634 11.6801 14.5634C11.7534 14.5626 11.8255 14.5439 11.89 14.5091C12.4005 14.2251 12.3054 12.4051 12.2827 12.0274C12.2827 11.9565 12.2812 11.2133 12.0199 10.8569C11.8326 10.5986 11.5139 10.5004 11.3206 10.4642C11.3988 10.3562 11.5019 10.2686 11.6211 10.2089C11.9716 10.0337 12.6029 10.008 13.2297 10.008H13.5786C14.2583 10.0171 14.4335 10.0609 14.6797 10.1228C15.1782 10.2421 15.1888 10.5639 15.1449 11.6649C15.1314 11.9776 15.1178 12.331 15.1178 12.7479C15.1178 12.8385 15.1132 12.9352 15.1132 13.0379C15.0981 13.5983 15.08 14.2342 15.4757 14.4955C15.5273 14.5278 15.587 14.5451 15.6479 14.5453C15.7854 14.5453 16.1992 14.5453 17.3199 12.6226C17.6656 12.0037 17.9659 11.3606 18.2186 10.6983C18.2413 10.659 18.3078 10.5382 18.3863 10.4914C18.4443 10.4618 18.5085 10.4468 18.5736 10.4476H21.2636C21.5567 10.4476 21.7576 10.4914 21.7953 10.6046C21.8618 10.7844 21.7832 11.3327 20.5553 12.9956L20.007 13.7191C18.8938 15.1782 18.8938 15.2522 20.0765 16.3593Z" />
                            </a>
                        </svg>
                    </div>
                </div>
                <div id="politics">
                    <p>политика конфиденциальности</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Конец мобильного меню -->
    <!-- Конец header -->
    <!-- Начало контента -->

    <div id="wrapper">
        <div id="news">
            <div id="сontentArticleBlock">
                <div id="imgArticle"></div>
                <? foreach ($massArticle as $elemArticle) { ?>
                    <? if ($elemArticle['id'] == $id) { ?>
                        <h2><?= $elemArticle['card_name']?></h2>
                        <div id="textContentArticle"><?= $elemArticle['main_text']?>

                        </div>
                        <h4><?= $elemArticle['subtitle']?></h4>
                        <div id="twoTextBlockArticle">
                            <div id="leftTextArticle">
                            <?= $elemArticle['subMain_text']?>
                            </div>
                            <div id="rightImgArticle"></div>
                        <? } ?>
                    <? } ?>
                </div>
                <a id="yakor"></a><!--Якорь-->
                <div id="commentsContainer">
                    <div class="read">
                        <div class="line"></div>
                        <h1>Комментарии</h1>
                        <div class="line"></div>
                    </div>
                    <!-- Форма написания комментария -->
                    <div id="commentBlock">
                        <div id="UserBlock">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="90" viewBox="0 0 20 22"
                                fill="none">
                                <path
                                    d="M0 28H20V23C19.9979 21.1441 19.2597 19.3649 17.9474 18.0526C16.6351 16.7403 14.8559 16.0021 13 16H7C5.14413 16.0021 3.36489 16.7403 2.05259 18.0526C0.740295 19.3649 0.00211736 21.1441 0 23V28ZM3 7C3 8.38447 3.41054 9.73785 4.17971 10.889C4.94888 12.0401 6.04213 12.9373 7.32122 13.4672C8.6003 13.997 10.0078 14.1356 11.3656 13.8655C12.7235 13.5954 13.9708 12.9287 14.9497 11.9497C15.9287 10.9708 16.5954 9.7235 16.8655 8.36563C17.1356 7.00777 16.997 5.6003 16.4672 4.32122C15.9373 3.04213 15.0401 1.94888 13.889 1.17971C12.7378 0.410543 11.3845 0 10 0C8.14348 0 6.36301 0.737498 5.05025 2.05025C3.7375 3.36301 3 5.14348 3 7Z"
                                    fill="#C9CBE5" />
                            </svg>
                        </div>
                        <div id="commentPlace">
                            <form action="" method="post">
                                <label for=""><input type="text" id="nick" name="nickComment"
                                        placeholder="Ваше имя"></label>
                                <div id="containerComment">
                                    <textarea id="comment" style="resize: none;margin-top:5px"
                                        name="textComment"></textarea>
                                    <a href="#yakor"><!--Якорь-->
                                        <button id="sendMessage">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                                viewBox="0 0 27 27" fill="none">
                                                <path
                                                    d="M2.03854 0.152604C0.92479 -0.404271 -0.310836 0.655103 0.0707268 1.84104L2.7501 10.1689C2.80278 10.3326 2.89948 10.4786 3.02961 10.5911C3.15974 10.7035 3.31829 10.778 3.48791 10.8064L14.6151 12.6617C15.1373 12.7489 15.1373 13.4989 14.6151 13.586L3.48885 15.4404C3.31906 15.4686 3.16031 15.543 3.03 15.6555C2.89969 15.7679 2.80285 15.9141 2.7501 16.0779L0.0707268 24.4085C-0.310836 25.5945 0.923852 26.6539 2.03854 26.097L25.4704 14.3829C26.5073 13.8645 26.5073 12.386 25.4704 11.8667L2.03854 0.152604Z"
                                                    fill="#C9CBE5" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Блок комментариев -->
                    <div id="placeAllComment">
                        <!-- Комментарий -->
                        <? foreach ($mass as $elem) { ?>
                            <? if ($elem['article_id'] == $id) { ?>
                                <div class="userCommentBlock">
                                    <div class="userIco">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="50" viewBox="0 0 20 22"
                                            fill="none">
                                            <path
                                                d="M0 28H20V23C19.9979 21.1441 19.2597 19.3649 17.9474 18.0526C16.6351 16.7403 14.8559 16.0021 13 16H7C5.14413 16.0021 3.36489 16.7403 2.05259 18.0526C0.740295 19.3649 0.00211736 21.1441 0 23V28ZM3 7C3 8.38447 3.41054 9.73785 4.17971 10.889C4.94888 12.0401 6.04213 12.9373 7.32122 13.4672C8.6003 13.997 10.0078 14.1356 11.3656 13.8655C12.7235 13.5954 13.9708 12.9287 14.9497 11.9497C15.9287 10.9708 16.5954 9.7235 16.8655 8.36563C17.1356 7.00777 16.997 5.6003 16.4672 4.32122C15.9373 3.04213 15.0401 1.94888 13.889 1.17971C12.7378 0.410543 11.3845 0 10 0C8.14348 0 6.36301 0.737498 5.05025 2.05025C3.7375 3.36301 3 5.14348 3 7Z"
                                                fill="#C9CBE5" />
                                        </svg>
                                    </div>
                                    <div class="userComment">
                                        <div class="userInfo">
                                            <div class="userName">
                                                <?= $elem['user_name'] ?>
                                            </div>
                                            <div class="commentDate">
                                                <?= $elem['date'] ?>
                                            </div>
                                        </div>
                                        <div class="textComment">
                                            <?= $elem['comments_text'] ?>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Конец контента -->
    <!-- Подвал -->
    <footer>
        <div id="social">
            <h4>Соц-сети автора:</h4>
            <div id="contSocial">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="29" height="29" viewBox="0 0 29 29"
                    fill="none">
                    <a xlink:href="https://github.com/Lafy-qx">
                        <path fill-rule="evenodd" clip-rule="evenodd" fill="#C9CBE5"
                            d="M14.4993 0C6.49191 0 0 6.65668 0 14.8679C0 21.4366 4.15369 27.0091 9.91614 28.9739C10.6419 29.1115 10.9059 28.6536 10.9059 28.2583C10.9059 27.9061 10.8932 26.9717 10.8869 25.7298C6.8533 26.629 6.00226 23.7364 6.00226 23.7364C5.34269 22.0191 4.39201 21.5624 4.39201 21.5624C3.07549 20.6406 4.49203 20.6585 4.49203 20.6585C5.94723 20.7641 6.71313 22.1902 6.71313 22.1902C8.00623 24.4622 10.1072 23.8046 10.933 23.4265C11.0642 22.4639 11.4398 21.8102 11.8536 21.4377C8.63419 21.0626 5.24937 19.7871 5.24937 14.0903C5.24937 12.4667 5.81413 11.1393 6.74138 10.0998C6.59304 9.72542 6.09446 8.21393 6.88378 6.16607C6.88378 6.16607 8.10104 5.76656 10.8717 7.69129C12.0276 7.36002 13.2682 7.19457 14.5015 7.18962C15.7329 7.19495 16.9739 7.36002 18.1313 7.69129C20.9001 5.76656 22.1155 6.16607 22.1155 6.16607C22.9067 8.21393 22.4084 9.72542 22.2597 10.0998C23.1892 11.1393 23.7499 12.4667 23.7499 14.0903C23.7499 19.8004 20.3602 21.0584 17.1301 21.4251C17.6498 21.8845 18.1138 22.7937 18.1138 24.1809C18.1138 26.1674 18.0964 27.7704 18.0964 28.2579C18.0964 28.6563 18.357 29.1195 19.0932 28.9719C24.8493 27.003 29 21.4347 29 14.8679C29 6.65668 22.5081 0 14.4993 0Z" />
                    </a>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="30" height="30" viewBox="0 0 30 30"
                    fill="none">
                    <a xlink:href="https://t.me/ka4an_qx">
                        <path fill="#C9CBE5"
                            d="M14.5312 0C6.50391 0 0 6.50391 0 14.5312C0 22.5586 6.50391 29.0625 14.5312 29.0625C22.5586 29.0625 29.0625 22.5586 29.0625 14.5312C29.0625 6.50391 22.5586 0 14.5312 0ZM21.668 9.95508L19.2832 21.1934C19.1074 21.9902 18.6328 22.1836 17.9707 21.8086L14.3379 19.1309L12.5859 20.8184C12.3926 21.0117 12.2285 21.1758 11.8535 21.1758L12.1113 17.4785L18.8438 11.3965C19.1367 11.1387 18.7793 10.9922 18.3926 11.25L10.0723 16.4883L6.48633 15.3691C5.70703 15.123 5.68945 14.5898 6.65039 14.2148L20.6602 8.8125C21.3105 8.57812 21.8789 8.9707 21.668 9.95508Z" />
                    </a>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="#C9CBE5" width="29" height="29" viewBox="0 0 29 29"
                    fill="none">
                    <a xlink:href="https://vk.com/who_asexual">
                        <path fill="#C9CBE5"
                            d="M14.5 0C6.49177 0 0 6.49177 0 14.5C0 22.5082 6.49177 29 14.5 29C22.5082 29 29 22.5082 29 14.5C29 6.49177 22.5082 0 14.5 0ZM20.0765 16.3593C20.0765 16.3593 21.3588 17.6251 21.6745 18.2126C21.6835 18.2247 21.6881 18.2368 21.6911 18.2428C21.8195 18.4588 21.8497 18.6265 21.7863 18.7518C21.6805 18.9603 21.318 19.063 21.1942 19.072H18.9285C18.7715 19.072 18.4422 19.0313 18.0434 18.7564C17.7368 18.5419 17.4347 18.1899 17.1402 17.8471C16.7007 17.3366 16.3201 16.8955 15.9364 16.8955C15.8877 16.8954 15.8392 16.9031 15.7929 16.9182C15.5029 17.0118 15.1314 17.4257 15.1314 18.5283C15.1314 18.8727 14.8595 19.0705 14.6677 19.0705H13.63C13.2766 19.0705 11.4354 18.9467 9.80411 17.2263C7.80734 15.1193 6.00995 10.8931 5.99484 10.8539C5.88156 10.5805 6.11568 10.434 6.37094 10.434H8.65922C8.96432 10.434 9.06401 10.6197 9.13349 10.7844C9.21505 10.9762 9.51411 11.739 10.005 12.5969C10.801 13.9955 11.2889 14.5634 11.6801 14.5634C11.7534 14.5626 11.8255 14.5439 11.89 14.5091C12.4005 14.2251 12.3054 12.4051 12.2827 12.0274C12.2827 11.9565 12.2812 11.2133 12.0199 10.8569C11.8326 10.5986 11.5139 10.5004 11.3206 10.4642C11.3988 10.3562 11.5019 10.2686 11.6211 10.2089C11.9716 10.0337 12.6029 10.008 13.2297 10.008H13.5786C14.2583 10.0171 14.4335 10.0609 14.6797 10.1228C15.1782 10.2421 15.1888 10.5639 15.1449 11.6649C15.1314 11.9776 15.1178 12.331 15.1178 12.7479C15.1178 12.8385 15.1132 12.9352 15.1132 13.0379C15.0981 13.5983 15.08 14.2342 15.4757 14.4955C15.5273 14.5278 15.587 14.5451 15.6479 14.5453C15.7854 14.5453 16.1992 14.5453 17.3199 12.6226C17.6656 12.0037 17.9659 11.3606 18.2186 10.6983C18.2413 10.659 18.3078 10.5382 18.3863 10.4914C18.4443 10.4618 18.5085 10.4468 18.5736 10.4476H21.2636C21.5567 10.4476 21.7576 10.4914 21.7953 10.6046C21.8618 10.7844 21.7832 11.3327 20.5553 12.9956L20.007 13.7191C18.8938 15.1782 18.8938 15.2522 20.0765 16.3593Z" />
                    </a>
                </svg>
            </div>
        </div>
        <div id="politic">
            <span>©Lafy-qx | Все права защищены.<a href="#" id="confidentiality">Политика конфиденциальности</a>.</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>