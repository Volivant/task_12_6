<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

// Функция разделения ФИО на фамилию имя отчество

function getPartsFromFullname($fullname)
{
    return explode(' ', $fullname);
}

// Функция соединения фамилии имени отчества в ФИО
function getFullnameFromParts($surname, $name, $patronomic)
{
    return $surname.' '.$name.' '.$patronomic;
}

// Функция сокращения ФИО
function getShortName($fullname)
{
    $arrFIO = getPartsFromFullname($fullname);
    return $arrFIO[1].' '.mb_substr($arrFIO[0], 0, 1).'.';
}

// Функция определения пола от отчества берем 2 последние буквы, потому как Никтична
function getGenderFromName($fullname)
{
    $arrFIO = getPartsFromFullname($fullname);
    $flagGender = 0;
    $surname = mb_substr($arrFIO[0], -2, 2);
    $name = mb_substr($arrFIO[1], -1, 1);
    $patronomic = mb_substr($arrFIO[2], -2, 2);
    if ($surname == 'ва') {
        $flagGender--;
    } elseif (mb_substr($surname, -1, 1) == 'в'){
        $flagGender++;
    } 
    if ($name == 'а') {
        $flagGender--;
    } elseif ($name == 'й' || $name == 'н'){
        $flagGender++;
    } 
    if ($patronomic == 'на') {
        $flagGender--;
    } elseif ($patronomic == 'ич'){
        $flagGender++;
    }
    if ($flagGender > 0) {
        return 1;
    } elseif ($flagGender < 0) {
        return -1;
    } else 
        return 0;
}

// Функция определения полового состава
function getGenderDescription($personsArray)
{
    $personsFullname = array_column($personsArray, 'fullname'); // извлекаем столбец fullname многомерного массива
    $personsMen = array_filter($personsFullname, function ($fullname) { //массив мужчин
        return getGenderFromName($fullname) == 1;
    });
    $personsWomen = array_filter($personsFullname, function ($fullname) { // массив женщин
        return getGenderFromName($fullname) == -1;
    });
    $personsNAN = array_filter($personsFullname, function ($fullname) { // массив NAN
        return getGenderFromName($fullname) == 0;
    });
    $countPersons = count($personsFullname);
    $countMen = count($personsMen);
    $countWomen = count($personsWomen);
    $countNAN = count($personsNAN);
    echo "<p>Гендерный состав аудитории:</p>";
    echo "<p>---------------------------</p>";
    echo "<p>Мужчины - ".round($countMen/$countPersons*100, 1)."%</p>";
    echo "<p>Женщины - ".round($countWomen/$countPersons*100, 1)."%</p>";
    echo "<p>Не удалось определить - ".round($countNAN/$countPersons*100, 1)."%</p>";
}

// Функция подбора пары
function getPerfectPartner($surname, $name, $patronomic, $personsArray)
{
    $surname = mb_convert_case($surname, MB_CASE_TITLE);
    $name = mb_convert_case($name, MB_CASE_TITLE);
    $patronomic = mb_convert_case($patronomic, MB_CASE_TITLE);
    $fullname = getFullnameFromParts($surname, $name, $patronomic);
    $gender = getGenderFromName($fullname);
    if ($gender != 0) {
        $numderPartner = rand(0, count($personsArray)-1);
        while ($gender + getGenderFromName($personsArray[$numderPartner]['fullname']) != 0) {
            $numderPartner = rand(0, count($personsArray)-1);
        }
        echo '<p>'.getShortName($fullname).' + '. getShortName($personsArray[$numderPartner]['fullname']) . ' =</p>'.
        "♡ Идеально на ".round(rand(5000, 10000)/100, 2)."% ♡";
    } else {
        echo 'Невозможно подобрать пару.';
    }
}