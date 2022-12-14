<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Функции обработки ФИО</title>
</head>
<body>
    <?php
        include 'functions.php';
    ?>
    <div>
        <form method="POST">
            <p><label for="inputSurname">Фамилия </label><input type="text" name="inputSurname">
            <label for="inputName">Имя </label><input type="text" name="inputName">
            <label for="inputPatronomyc">Отчество </label><input type="text" name="inputPatronomyc"></p>
            <input type="submit" name="btnSubmit" value="fullnameFromParts">
            <p><label for="inputFullname">ФИО </label><input type="text" name="inputFullname"></p>
            <p><input type="submit" name="btnSubmit" value="partsFromFullname">
            <input type="submit" name="btnSubmit" value="getShortName">
            <input type="submit" name="btnSubmit" value="getGenderFromName"></p>
            <input type="submit" name="btnSubmit" value="getGenderDescription">
            <input type="submit" name="btnSubmit" value="getPerfectPartner">
        </form>
    </div>
    <div>
        <?php
            $btnClick = $_POST['btnSubmit'];
            switch ($btnClick) {
                case 'fullnameFromParts':
                    echo getFullnameFromParts($_POST['inputSurname'], $_POST['inputName'],$_POST['inputPatronomyc']);
                    break;
                case 'partsFromFullname':
                    $arrFIO = getPartsFromFullname($_POST['inputFullname']);
                    echo 'Фамилия: '.$arrFIO[0];
                    echo ' Имя: '.$arrFIO[1];
                    echo ' Отчество: '.$arrFIO[2];
                    break;
                case 'getShortName':
                    echo getShortName($_POST['inputFullname']);
                    break;
                case 'getGenderFromName':
                    $getGender = getGenderFromName($_POST['inputFullname']);
                    if ($getGender == 1) {
                        echo 'Пол мужской';
                    } elseif ($getGender == -1) {
                        echo 'Пол женский';
                    } else echo 'Пол не определен';
                    break;
                case 'getGenderDescription':
                    echo getGenderDescription($example_persons_array);
                    break;
                case 'getPerfectPartner':
                    echo getPerfectPartner($_POST['inputSurname'], $_POST['inputName'],$_POST['inputPatronomyc'], $example_persons_array);
                    break;
            }
        ?>
    </div>
</body>
</html>
