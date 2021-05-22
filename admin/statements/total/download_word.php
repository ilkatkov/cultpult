<?php
require '../../../vendor/autoload.php';
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";

session_start();

$state = getState($_SESSION['Username']);
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "1") {
    $link = connectDB();

    $events = getevents(); // получаем весь список групп

    // получаем выбранную юзером дату
    $date_sql = $_GET['date']; // дата в запросе
    setlocale(LC_ALL, 'ru_RU.utf8');
    $date = date("d.m.Y", strtotime($date_sql)); // data in path
    $day = date("j", strtotime($date_sql));
    $month = date("F", strtotime($date_sql));
    switch ($month) {
        case "January":
            $month =  "января";
            break;
        case "February":
            $month =  "февраля";
            break;
        case "March":
            $month = "марта";
            break;
        case "April":
            $month = "апреля";
            break;
        case "May":
            $month = "мая";
            break;
        case "June":
            $month = "июня";
            break;
        case "July":
            $month = "июля";
            break;
        case "August":
            $month = "августа";
            break;
        case "September":
            $month = "сентября";
            break;
        case "October":
            $month = "октября";
            break;
        case "November":
            $month = "ноября";
            break;
        case "December":
            $month = "декабря";
            break;
    }
    $year = date("Y", strtotime($date_sql));
    $date_current = date("j F Y");

    // создаем документ Word
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    //$phpWord->setDefaultFontName('Times New Roman');
    //$phpWord->setDefaultFontSize(14);

    $properties = $phpWord->getDocInfo();
    $properties->setCreator('КультПульт Moscow');
    $properties->setCompany('КультПульт Moscow');
    $properties->setLastModifiedBy('КультПульт Moscow');

    $sectionStyle = array(
        'orientation' => 'portrait',
        'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
        'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
        'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3),
        'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
    );
    $section = $phpWord->addSection($sectionStyle);


    // получаем настройки
    $query_settings = "SELECT * FROM settings";
    $settings_sql = mysqli_query($link, $query_settings);
    for ($settings_data = []; $row = mysqli_fetch_assoc($settings_sql); $settings_data[] = $row);

    $company_name = $settings_data[0]['company_name'];
    $company_address = $settings_data[0]['company_address'];
    $company_department = $settings_data[0]['company_department'];
    $company_manager = $settings_data[0]['company_manager'];
    $company_responsible = $settings_data[0]['company_responsible'];
    $company_contract = $settings_data[0]['company_contract'];
    $dr_number = (string)$settings_data[0]['dr_number'];


    // шапка
    $br = " ";
    $section->addText(htmlspecialchars($br), array('name'=>'Times New Roman', 'size' => 12), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));
    $section->addText(htmlspecialchars("ЗАЯВКА"), array('name'=>'Times New Roman', 'bold' => TRUE, 'size' => 16), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
    $section->addText(htmlspecialchars("На оказание услуг по организации питания"), array('name'=>'Times New Roman', 'bold' => TRUE, 'size' => 13), array('align' => 'center', 'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
    $section->addText(htmlspecialchars("и обеспечению питьевого режима обучающихся"), array('name'=>'Times New Roman', 'bold' => TRUE, 'size' => 13), array('align' => 'center', 'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
    $section->addText(htmlspecialchars($company_name), array('name'=>'Times New Roman', 'underline' => 'single', 'size' => 14), array('align' => 'center', 'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
    $section->addText(htmlspecialchars("(указать наименование образовательной организации)"), array('name'=>'Times New Roman', 'superScript' => TRUE, 'italic' => TRUE, 'size' => 12), array('align' => 'center', 'spaceBefore' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)));
    //$section->addText(htmlspecialchars($br), array(), array('align' => 'center', 'space' => array('before' => 0, 'after' => 0)));

    // таблица инфо
    $TableStyleName = 'Info';
    $TableStyle = array('borderSize' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
    $TitleCellStyle = array('valign' => 'center', 'valign' => 'top', 'bgcolor' => 'f1f1f1');
    $InfoCellStyle = array('valign' => 'center', 'valign' => 'top');
    $TableFontStyle = array('bold' => false);
    $phpWord->addTableStyle($TableStyleName, $TableStyle);
    $table_info = $section->addTable($TableStyleName);
    $title_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7.23);
    $info_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.35);
    $row_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.55);
    $table_info->addRow($row_height);
    $table_info->addCell($title_width, $TitleCellStyle)->addText('  Номер контракта(договора):', array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 12, 'lineHeight' => 1), $TableFontStyle);
    $table_info->addCell($info_width, $InfoCellStyle)->addText('  ' . $company_contract, array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => 12, 'lineHeight' => 1), $TableFontStyle);
    $table_info->addRow($row_height);
    $table_info->addCell($title_width, $TitleCellStyle)->addText('  Дата оказания услуг:', array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1), $TableFontStyle);
    $table_info->addCell($info_width, $InfoCellStyle)->addText('  ' . $day . " " . $month . " " . $year, array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1), $TableFontStyle);
    $table_info->addRow($row_height);
    $table_info->addCell($title_width, $TitleCellStyle)->addText('  Место оказания услуг:', array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1), $TableFontStyle);
    $table_info->addCell($info_width, $InfoCellStyle)->addText('  ' . $company_address, array('name'=>'Times New Roman', 'size' => 12), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1), $TableFontStyle);

    $section->addText(htmlspecialchars($br), array('name'=>'Times New Roman', 'size' => 13.5), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));
    $section->addText(htmlspecialchars("        Объем оказываемых услуг:"), array('name'=>'Times New Roman', 'size' => 13.5), array('align' => 'left','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));

    $TableStyleName = 'Main';
    $TableStyle = array('borderSize' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
    $phpWord->addTableStyle($TableStyleName, $TableStyle);
    $table_main = $section->addTable($TableStyleName);
    $TitleCellStyle = array('valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $InfoCellStyle = array('valign' => 'center', 'valign' => 'center');
    $category_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.28);
    $settings_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.28);
    $breakfast_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2);
    $second_breakfast_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.75);
    $lunch_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25);
    $snack_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5);
    $dinner_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25);
    $second_dinner_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.53);
    $row_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.55);
    $row2_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8);
    $row3_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.3);
    $table_main->addRow();
    $categoryCellStyle = array('vMerge' => 'restart', 'valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $settingsCellStyle = array('gridSpan' => 6, 'valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $forCategoryCellStyle = array('vMerge' => 'continue', 'valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');

    $category_cell = $table_main->addCell($category_width, $categoryCellStyle);

    $category_cell->addText('Категории питающихся', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $category_cell->addText('(в соответствии с приложением №1 к Техническому заданию)', array('name'=>'Arial', 'size' => 9), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($settings_width, $settingsCellStyle)->addText('Потребность в рационах питания', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addRow($row2_height);
    $table_main->addCell($category_width, $forCategoryCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($breakfast_width, $TitleCellStyle)->addText('Завтрак', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_breakfast_height, $TitleCellStyle)->addText('Второй завтрак', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($lunch_height, $TitleCellStyle)->addText('Обед', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($snack_height, $TitleCellStyle)->addText('Полдник', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($dinner_height, $TitleCellStyle)->addText('Ужин', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_dinner_height, $TitleCellStyle)->addText('Второй ужин', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addRow($row3_height);
    $table_main->addCell($category_width, $forCategoryCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($breakfast_width, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_breakfast_height, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($lunch_height, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($snack_height, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($dinner_height, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_dinner_height, $TitleCellStyle)->addText('Кол-во(шт)', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);

    // находим и записываем количество обедов
    $query_count = "SELECT COUNT(id) FROM archive WHERE date = '" . mysqli_real_escape_string($link, $date_sql) . "'";
    $count_sql = mysqli_query($link, $query_count);
    for ($count_data = []; $i = mysqli_fetch_assoc($count_sql); $count_data[] = $i);

    $table_main->addRow();
    $participants_text = $table_main->addCell($category_width, $InfoCellStyle);
    $participants_text->addText('  Обучающиеся, осваивающие', array('name'=>'Times New Roman', 'size' => 9), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $participants_text->addText('  образовательные программы среднего ', array('name'=>'Times New Roman', 'size' => 9), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $participants_text->addText('  профессионального образования', array('name'=>'Times New Roman', 'size' => 9), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $participants_text->addText('  (студенты)', array('name'=>'Times New Roman', 'size' => 9, 'underline' => TRUE), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($breakfast_width, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_breakfast_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($lunch_height, $InfoCellStyle)->addText($count_data[0]["COUNT(id)"], array('name'=>'Times New Roman', 'size' => 12), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($snack_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($dinner_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_main->addCell($second_dinner_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);

    $row4_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.5);
    for ($i = 0; $i < 10; $i++)
    {
        $table_main->addRow($row4_height);
        $participants_text = $table_main->addCell($category_width, $InfoCellStyle)->addText('', array('name'=>'Times New Roman', 'size' => 9), array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($breakfast_width, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($second_breakfast_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($lunch_height, $InfoCellStyle)->addText('', array('name'=>'Times New Roman', 'size' => 12), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($snack_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($dinner_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
        $table_main->addCell($second_dinner_height, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);

    }

    $section->addText(htmlspecialchars($br), array('name'=>'Times New Roman', 'size' => 13.5), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));

    $TableStyleName = 'Water';
    $TableStyle = array('borderSize' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
    $phpWord->addTableStyle($TableStyleName, $TableStyle);
    $table_water = $section->addTable($TableStyleName);
    $TitleCellStyle = array('valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $InfoCellStyle = array('valign' => 'center', 'valign' => 'center');
    $water_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.76);
    $count_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.74);

    $row_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.55);
    $row2_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.8);
    $row3_height = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.3);
    $table_water->addRow();
    $waterCellStyle = array('vMerge' => 'restart', 'valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $settingsCellStyle = array('valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');
    $forWaterCellStyle = array('vMerge' => 'continue', 'valign' => 'center', 'valign' => 'center', 'bgcolor' => 'f1f1f1');

    $water_cell = $table_water->addCell($category_width, $waterCellStyle);
    $water_cell->addText('Комплекты', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $water_cell->addText('бутилированной воды', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_water->addCell($settings_width, $settingsCellStyle)->addText('Потребность в бутилированной воде,к-тов.', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_water->addRow($row2_height);
    $table_water->addCell($category_width, $forWaterCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);
    $table_water->addCell($settings_width, $InfoCellStyle)->addText('', array('name'=>'Arial', 'size' => 9, 'bold' => TRUE), array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'lineHeight' => 1), $TableFontStyle);

    $section->addText(htmlspecialchars($br), array('name'=>'Times New Roman', 'size' => 13.5), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));

    $section->addText(htmlspecialchars('« ' . $day . " » " . $month . " " . $year . " г. ___________________ " . $company_responsible), array('name'=>'Times New Roman', 'size' => 13.5), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));
    $section->addText(htmlspecialchars('                                                                          Подпись'), array('name'=>'Times New Roman', 'size' => 12, 'italic' => TRUE), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));
    $section->addText(htmlspecialchars('                                                                        (представителя Заказчика)'), array('name'=>'Times New Roman', 'size' => 12, 'italic' => TRUE), array('align' => 'center','spaceBefore' => 0, 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'lineHeight' => 1));

    //    // таблица
//    $TableStyleName = 'Ведомость';
//    $TableStyle = array('borderSize' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
//    $TableCellStyle = array('valign' => 'center');
//    $TableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
//    $TableFontStyle = array('bold' => false);
//    $phpWord->addTableStyle($TableStyleName, $TableStyle);
//    $table = $section->addTable($TableStyleName);
//    $table->addRow();
//    $n_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.4);
//    $time_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.15);
//    $event_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.25);
//    $curator_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(5.5);
//    $count_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.25);
//
//    $table->addCell($n_width, $TableCellStyle)->addText('№ п/п', array(), array('align' => 'center'), $TableFontStyle);
//    if ($date == $date_current) {
//        $table->addCell($time_width, $TableCellStyle)->addText('Время', array(), array('align' => 'center'), $TableFontStyle);
//    }
//    $table->addCell($event_width, $TableCellStyle)->addText('Группа', array(), array('align' => 'center'), $TableFontStyle);
//    $table->addCell($curator_width, $TableCellStyle)->addText('ФИО куратора', array(), array('align' => 'center'), $TableFontStyle);
//    if ($date == $date_current) {
//        $table->addCell($curator_width, $TableCellStyle)->addText('ФИО преподавателя', array(), array('align' => 'center'), $TableFontStyle);
//    }
//    $table->addCell($count_width, $TableCellStyle)->addText('Количество обедов', array(), array('align' => 'center'), $TableFontStyle);
//    $summa = 0;
//    $row_n = 1;
//    for ($row = 0; $row <= count($events) - 1; $row++) {
//        if ($date == $date_current) {
//            $temp_event = $events[array_search($events[$row]['id'], array_column($events, 'id'))]['name'];
//            $temp_time = $events[$row]['time'];
//            $temp_curator = explode(" ", $events[array_search($events[$row]['id'], array_column($events, 'id'))]['curator']);
//            $temp_curator = $temp_curator[0] . " " . substr($temp_curator[1], 0, 2) . "." . substr($temp_curator[2], 0, 2) . ".";
//            $temp_code = getCodeOnTime($temp_time)[0]['id'];
//        }
//        else {
//            $temp_event = $events[$row]['name'];
//            $temp_time = $events[$row]['time'];
//            // var_dump($temp_time);
//            $temp_curator = explode(" ", $events[array_search($events[$row]['id'], array_column($events, 'id'))]['curator']);
//            $temp_curator = $temp_curator[0] . " " . substr($temp_curator[1], 0, 2) . "." . substr($temp_curator[2], 0, 2) . ".";
//            $temp_code = geteventCodeOnName(mb_convert_encoding($temp_event, "UTF-8"));
//        }
//
//        if ($date == $date_current) {
//            $temp_teacher = getTeacher($temp_code);
//        }
//        if ($temp_time != "00:00") {
//            $table->addRow();
//            $table->addCell($n_width)->addText($row_n, array(), array('align' => 'center'));
//            if ($date == $date_current) {
//                $table->addCell($time_width)->addText($temp_time, array(), array('align' => 'center'));
//            }
//            $table->addCell($event_width)->addText(mb_convert_encoding($temp_event, "UTF-8"), array(), array('align' => 'center'));
//            $table->addCell($curator_width)->addText(mb_convert_encoding($temp_curator, "UTF-8"), array(), array('align' => 'center'));
//            if ($date == $date_current) {
//                $table->addCell($curator_width)->addText(mb_convert_encoding($temp_teacher, "UTF-8"), array(), array('align' => 'center'));
//            }
//
//            //находим и записываем количество обедов
//            $query_count = "SELECT COUNT(id) FROM archive WHERE date = '" . mysqli_real_escape_string($link, $date_sql) . "' AND events = '" . mysqli_real_escape_string($link, $temp_code) . "'";
//            $count_sql = mysqli_query($link, $query_count);
//            for ($count_data = []; $i = mysqli_fetch_assoc($count_sql); $count_data[] = $i);
//            $summa = $summa + (int)$count_data[0]["COUNT(id)"];
//            $table->addCell($count_width)->addText((string)$count_data[0]["COUNT(id)"], array(), array('align' => 'center'));
//            $row_n = $row_n + 1;
//        }
//    }
//    $table->addRow();
//    if ($date == $date_current) {
//        $cellColSpan = array('gridSpan' => 5, 'valign' => 'center');
//    } else {
//        $cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
//    }
//    $table->addCell($n_width, $cellColSpan)->addText('Всего', array(), array('align' => 'center'), $TableFontStyle);
//    $table->addCell($count_width, $TableCellStyle)->addText((string)$summa, array(), array('align' => 'center'));
//
//    $section->addText(htmlspecialchars($text), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("Заведующие отделениями:"), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("__________ ______________"), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("__________ ______________"), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("__________ ______________"), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars($text), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("Заместитель директора по УВР"), array(), array('align' => 'left'));
//    $section->addText(htmlspecialchars("__________ ______________"), array(), array('align' => 'left'));

    // сохранение и скачивание файла
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $file_name = 'fl_' . $date . '.docx';
    $objWriter->save('../../../storage/total/' . $file_name);
    header("Content-Length: " . filesize('../../../storage/total/' . $file_name));
    header("Content-Disposition: attachment; filename=" . $file_name);
    header("Content-Type: application/x-force-download; name=\"" . '../../../storage/total/' . $file_name . "\"");
    readfile('../../../storage/total/' . $file_name);
} else {
    ?>
    <form>
        <p class="login_mes">Возврат на главную...</p>
        <meta http-equiv='refresh' content='1;../..index.php'>
    </form>
    <?php
}
?>