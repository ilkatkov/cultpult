<?php

require_once '../../../vendor/autoload.php';
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";
require_once "DateParser.php";
session_start();

$state = getState($_SESSION['Username']);
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "1") {
    /** Error reporting */
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);

    /** Include PHPExcel */
    require_once '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';

    /** Include PHPExcel_IOFactory */
    require_once '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    // // echo date('H:i:s') , " Set document properties" , EOL;
    $objPHPExcel->getProperties()->setCreator("КультПульт Moscow")
        ->setLastModifiedBy("КультПульт Moscow")
        ->setTitle("КультПульт Moscow")
        ->setSubject("КультПульт Moscow")
        ->setDescription("КультПульт Moscow")
        ->setKeywords("office КультПульт moscow")
        ->setCategory("Total");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // document fields
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);

    // margins in INCH
    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.24);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.51);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.31);

    // A4 and orientation
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    // column's width
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12.71 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11.43 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12.57 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7.14 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.71 + 0.72);

    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(15);
    $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(14.25);
    $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(13.5);

    // sql connect
    $link = connectDB();

    $events = getevents();

    // sort function on 'name'
    function mySort($a, $b)
    {
        if ($a['name'] == $b['name']) return 0;

        return $a['name'] > $b['name'] ? 1 : -1;
    }

    usort($events, 'mySort');

// получаем выбранный юзером месяц
    $month = (string)$_GET['month']; // месяц в запросе
    $year = (string)$_GET['year']; // год в запросе

    $file_name = 'fl_month_' . $month . "_" . $year . '.xlsx';


    $getDates = new DateParser();
    $dates_in_month = $getDates->parseDate($month, $year);

    setlocale(LC_ALL, 'ru_RU.utf8');
    switch ($month) {
        case "01":
            $month = "январь";
            break;
        case "02":
            $month = "февраль";
            break;
        case "03":
            $month = "март";
            break;
        case "04":
            $month = "апрель";
            break;
        case "05":
            $month = "май";
            break;
        case "06":
            $month = "июнь";
            break;
        case "07":
            $month = "июль";
            break;
        case "08":
            $month = "август";
            break;
        case "09":
            $month = "сентябрь";
            break;
        case "10":
            $month = "октябрь";
            break;
        case "11":
            $month = "ноябрь";
            break;
        case "12":
            $month = "декабрь";
            break;
    }


    // get settings
    $query_settings = "SELECT * FROM settings";
    $settings_sql = mysqli_query($link, $query_settings);
    for ($settings_data = []; $row = mysqli_fetch_assoc($settings_sql); $settings_data[] = $row) ;

    $company_name = $settings_data[0]['company_name'];
    $company_fullname = $settings_data[0]['company_fullname'];
    $company_address = $settings_data[0]['company_address'];
    $company_department = $settings_data[0]['company_department'];
    $company_manager = $settings_data[0]['company_manager'];
    $company_director = $settings_data[0]['company_director'];
    $company_resource = $settings_data[0]['company_resource'];
    $company_responsible = $settings_data[0]['company_responsible'];
    $company_contract = $settings_data[0]['company_contract'];
    $company_price = $settings_data[0]['company_price'];
    $dr_number = (string)$settings_data[0]['dr_number'];


    // logo
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('logo_img');
    $objDrawing->setDescription('logo_img');
    $objDrawing->setPath('logo.png');
    $objDrawing->setCoordinates('A1');
//setOffsetX works properly
    $objDrawing->setOffsetX(5);
    $objDrawing->setOffsetY(5);
//set width, height
    $objDrawing->setWidth(114);
    $objDrawing->setHeight(136);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    // styles for шапка
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    // шапка
    $objPHPExcel->getActiveSheet()->mergeCells('C1:H7');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', $company_fullname);
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('C1'), 'C1:H7');

    // styles for утверждаю & заказчик
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('G9'), 'G9:H10');
    // утверждаю
    $objPHPExcel->getActiveSheet()->mergeCells('G9:H9');
    $objPHPExcel->getActiveSheet()->setCellValue('G9', '"Утверждаю"');

    // заказчик
    $objPHPExcel->getActiveSheet()->mergeCells('G10:H10');
    $objPHPExcel->getActiveSheet()->setCellValue('G10', '"Заказчик"');

    // styles for директор & подпись
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('D11'), 'D11:H12');

    // директор ...
    $objPHPExcel->getActiveSheet()->mergeCells('D11:H11');
    $objPHPExcel->getActiveSheet()->setCellValue('D11', "Директор " . $company_name);

    // подпись директора ...
    $objPHPExcel->getActiveSheet()->mergeCells('D12:H12');
    $objPHPExcel->getActiveSheet()->setCellValue('D12', "__________________________ " . $company_director);

    // styles for СВОДНЫЙ ОТЧЕТ ПО ПИТАНИЮ & Отделение
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('G15')->applyFromArray($styleArray);

    // СВОДНЫЙ ОТЧЕТ ПО ПИТАНИЮ
    $objPHPExcel->getActiveSheet()->mergeCells('C14:F14');
    $objPHPExcel->getActiveSheet()->setCellValue('C14', "СВОДНЫЙ ОТЧЕТ ПО ПИТАНИЮ");

    // Отделение
    $objPHPExcel->getActiveSheet()->mergeCells('G15:H15');
    $objPHPExcel->getActiveSheet()->setCellValue('G15', $company_department);

    // за ___ месяц ___ г.
    $objPHPExcel->getActiveSheet()->mergeCells('C15:F15');
    $objPHPExcel->getActiveSheet()->setCellValue('C15', "За  " . $month . "  месяц   " . $year . " г.");

    // styles for за ___ месяц ___ г.
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('C15')->applyFromArray($styleArray);


    $objPHPExcel->getActiveSheet()->setCellValue('A16', '№ п/п');
    $objPHPExcel->getActiveSheet()->setCellValue('B16', 'Дата');
    $objPHPExcel->getActiveSheet()->setCellValue('C16', 'Кол-во заказанных обедов в день');
    $objPHPExcel->getActiveSheet()->setCellValue('D16', 'Стоимость меню');
    $objPHPExcel->getActiveSheet()->setCellValue('E16', 'Сумма в день');
    $objPHPExcel->getActiveSheet()->setCellValue('F16', 'Суточная проба');
    $objPHPExcel->getActiveSheet()->setCellValue('G16', 'Стоимость');
    $objPHPExcel->getActiveSheet()->setCellValue('H16', 'Сумма в день');
    $objPHPExcel->getActiveSheet()->setCellValue('I16', 'Кол-во студентов на практике');

    // styles for table titles
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A16'), 'A16:I16');
    $objPHPExcel->getActiveSheet()->getStyle('A16:I16')->getAlignment()->setWrapText(true);



    // data
    $start = 17;
    $row = 17;
    $count = 1;
    $count_id = 1;
    $date_count = 0;
    while ($date_count < count($dates_in_month)){
        $current_date_sql = new DateTime($dates_in_month[$count-1]);
        $current_date_sql = (string)$current_date_sql->format('Y-m-d');
        $lunches = getAllLunchOnday($current_date_sql);
        if($lunches > 0){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row, $count_id);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row, $dates_in_month[$date_count]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row, $lunches);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row, $company_price);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row, '=C' .(string)$row . "*D".(string)$row);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row, '1');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row, $company_price);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row, '=E' .(string)$row . "+G".(string)$row);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row, ' ');
            $row++;
            $count_id++;
        }
        $count++;
        $date_count++;


    }
    $row_end = 47-$row;
    for ($row_space = $row; $row_space <= $row + $row_end; $row_space++){
        $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, $count_id);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, ' ');
        $count++;
        $count_id++;
    }

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A17')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A17'), 'A17:I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('A17:I' . (string)$row_space)->getAlignment()->setWrapText(true);


    // total
    $range = 'A' . (string)$row_space . ':B'. (string)$row_space;
//    var_dump($range);
    $objPHPExcel->getActiveSheet()->mergeCells($range);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'ИТОГО');
    $sum_end_point = $row_space-1;
    $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row_space, '=SUM(C17:C' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, '=SUM(D17:D' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, '=SUM(E17:E' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, '=SUM(F17:F' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, '=SUM(G17:G' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, '=SUM(H17:H' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, '=SUM(I17:I' . (string)$sum_end_point .')');



    // styles for table total
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_space)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_space ), 'A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_space . ':I'. (string)$row_space)->getAlignment()->setWrapText(true);

//    $created_date1 = new DateTime($date1);
//    $created_date2 = new DateTime($date2);
//
//
//    while($created_date1->format("Y-n") < $created_date2->format("Y-n")) {
//        $created_date1->setDate($created_date1->format("Y"), $created_date1->format("m"),$day1);
//        echo $created_date1->format("Y-m-d")."<br/>";
//        $created_date1->modify("+1 day");
//    }
    $row_names_start = $row_space+1;
    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Специалист по питанию ' . $company_name . '             _____________________/' . $company_responsible . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Зам.директора по управлению ресурсами ' . $company_name . '_____________________/' . $company_resource . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Заведующий отделением ' . $company_name . '_____________________/' . $company_manager . '/');

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );

    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start), 'A' . (string)$row_names_start . ':I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start . ':I' . (string)$row_space)->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->setTitle("Отчет");
    $objPHPExcel->setActiveSheetIndex(0);



    // Create a second sheet
    $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(1);

    // document fields
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);

    // margins in INCH
    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.24);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.31);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.31);

    // A4 and orientation
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    // column's width
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.57 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.57 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12.43 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.43 + 0.72);

    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(15);
    $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(14.25);
    $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(14)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(15)->setRowHeight(13.5);

    // logo
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('logo_img');
    $objDrawing->setDescription('logo_img');
    $objDrawing->setPath('logo.png');
    $objDrawing->setCoordinates('A1');
//setOffsetX works properly
    $objDrawing->setOffsetX(5);
    $objDrawing->setOffsetY(5);
//set width, height
    $objDrawing->setWidth(114);
    $objDrawing->setHeight(136);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    // styles for шапка
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    // шапка
    $objPHPExcel->getActiveSheet()->mergeCells('D1:I7');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', $company_fullname);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('D1'), 'D1:I7');

    // styles for утверждаю & заказчик
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('H9'), 'H9:H10');
    // утверждаю
    $objPHPExcel->getActiveSheet()->mergeCells('H9:I9');
    $objPHPExcel->getActiveSheet()->setCellValue('H9', '"Утверждаю"');

    // заказчик
    $objPHPExcel->getActiveSheet()->mergeCells('H10:I10');
    $objPHPExcel->getActiveSheet()->setCellValue('H10', '"Заказчик"');

    // styles for директор & подпись
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('E11'), 'E11:I12');

    // директор ...
    $objPHPExcel->getActiveSheet()->mergeCells('E11:I11');
    $objPHPExcel->getActiveSheet()->setCellValue('E11', "Директор " . $company_name);

    // подпись директора ...
    $objPHPExcel->getActiveSheet()->mergeCells('E12:I12');
    $objPHPExcel->getActiveSheet()->setCellValue('E12', "__________________________ " . $company_director);

    // styles for ОТЧЕТ ПО ПИТАНИЮ СПО ППССЗ & Отделение
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('H15')->applyFromArray($styleArray);

    // СВОДНЫЙ ОТЧЕТ ПО ПИТАНИЮ
    $objPHPExcel->getActiveSheet()->mergeCells('D14:G14');
    $objPHPExcel->getActiveSheet()->setCellValue('D14', "ОТЧЕТ ПО ПИТАНИЮ СПО ППССЗ");

    // Отделение
    $objPHPExcel->getActiveSheet()->mergeCells('H15:I15');
    $objPHPExcel->getActiveSheet()->setCellValue('H15', $company_department);

    // за ___ месяц ___ г.
    $objPHPExcel->getActiveSheet()->mergeCells('D15:G15');
    $objPHPExcel->getActiveSheet()->setCellValue('D15', "За  " . $month . "  месяц   " . $year . " г.");

    // styles for за ___ месяц ___ г.
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('D15')->applyFromArray($styleArray);


    $objPHPExcel->getActiveSheet()->setCellValue('B16', '№ п/п');
    $objPHPExcel->getActiveSheet()->setCellValue('C16', 'Дата');
    $objPHPExcel->getActiveSheet()->setCellValue('D16', 'Кол-во заказанных обедов в день');
    $objPHPExcel->getActiveSheet()->setCellValue('E16', 'Стоимость меню');
    $objPHPExcel->getActiveSheet()->setCellValue('F16', 'Стоимость меню со снижением');
    $objPHPExcel->getActiveSheet()->setCellValue('G16', 'Сумма в день');
    $objPHPExcel->getActiveSheet()->setCellValue('H16', 'Сумма в день со снижением');
    $objPHPExcel->getActiveSheet()->setCellValue('I16', 'Кол-во студентов на практике');

    // styles for table titles
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('B16')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B16'), 'B16:I16');
    $objPHPExcel->getActiveSheet()->getStyle('B16:I16')->getAlignment()->setWrapText(true);

// data
    $start = 17;
    $row = 17;
    $count = 1;
    $count_id = 1;
    $date_count = 0;
    while ($date_count < count($dates_in_month)){
        $current_date_sql = new DateTime($dates_in_month[$count-1]);
        $current_date_sql = (string)$current_date_sql->format('Y-m-d');
        $lunches = getSPOLunchOnday($current_date_sql);
        if($lunches > 0){
            $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row, $count_id);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row, $dates_in_month[$date_count]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row, $lunches);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row, $company_price);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row, ' ');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row, '=D' .(string)$row . "*E".(string)$row);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row, ' ');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row, ' ');

            $row++;
            $count_id++;
        }
        $count++;
        $date_count++;


    }
    $row_end = 47-$row;
    for ($row_space = $row; $row_space <= $row + $row_end; $row_space++){
        $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row_space, $count_id);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, ' ');
        $count++;
        $count_id++;
    }

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('B17')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B17'), 'B17:I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('B17:I' . (string)$row_space)->getAlignment()->setWrapText(true);


    // total
    $range = 'B' . (string)$row_space . ':C'. (string)$row_space;
//    var_dump($range);
    $objPHPExcel->getActiveSheet()->mergeCells($range);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row_space, 'ИТОГО');
    $sum_end_point = $row_space-1;
    $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, '=SUM(D17:D' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, '=SUM(E17:E' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, ' ');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, '=SUM(G17:G' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, '');
    $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, '=SUM(I17:I' . (string)$sum_end_point .')');



    // styles for table total
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space ), 'B' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space . ':I'. (string)$row_space)->getAlignment()->setWrapText(true);

//    $created_date1 = new DateTime($date1);
//    $created_date2 = new DateTime($date2);
//
//
//    while($created_date1->format("Y-n") < $created_date2->format("Y-n")) {
//        $created_date1->setDate($created_date1->format("Y"), $created_date1->format("m"),$day1);
//        echo $created_date1->format("Y-m-d")."<br/>";
//        $created_date1->modify("+1 day");
//    }
    $row_names_start = $row_space+1;
    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Специалист по питанию ' . $company_name . '             _____________________/' . $company_responsible . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Зам.директора по управлению ресурсами ' . $company_name . '_____________________/' . $company_resource . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Заведующий отделением ' . $company_name . '_____________________/' . $company_manager . '/');

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );

    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start), 'A' . (string)$row_names_start . ':I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start . ':I' . (string)$row_space)->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->setTitle("СПО");

    // Create a third sheet
    $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(2);

    // document fields
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);

    // margins in INCH
    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.24);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.31);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.31);

    // A4 and orientation
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    // column's width
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.57 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.57 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12.29 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12.43 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11.86 + 0.72);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.43 + 0.72);

    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(15);
    $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(14.25);
    $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(13.5);
    $objPHPExcel->getActiveSheet()->getRowDimension(14)->setRowHeight(15.75);
    $objPHPExcel->getActiveSheet()->getRowDimension(15)->setRowHeight(13.5);

    // logo
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('logo_img');
    $objDrawing->setDescription('logo_img');
    $objDrawing->setPath('logo.png');
    $objDrawing->setCoordinates('A1');
//setOffsetX works properly
    $objDrawing->setOffsetX(5);
    $objDrawing->setOffsetY(5);
//set width, height
    $objDrawing->setWidth(114);
    $objDrawing->setHeight(136);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    // styles for шапка
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    // шапка
    $objPHPExcel->getActiveSheet()->mergeCells('D1:I7');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', $company_fullname);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('D1'), 'D1:I7');

    // styles for утверждаю & заказчик
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('H9'), 'H9:H10');
    // утверждаю
    $objPHPExcel->getActiveSheet()->mergeCells('H9:I9');
    $objPHPExcel->getActiveSheet()->setCellValue('H9', '"Утверждаю"');

    // заказчик
    $objPHPExcel->getActiveSheet()->mergeCells('H10:I10');
    $objPHPExcel->getActiveSheet()->setCellValue('H10', '"Заказчик"');

    // styles for директор & подпись
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('E11'), 'E11:I12');

    // директор ...
    $objPHPExcel->getActiveSheet()->mergeCells('E11:I11');
    $objPHPExcel->getActiveSheet()->setCellValue('E11', "Директор " . $company_name);

    // подпись директора ...
    $objPHPExcel->getActiveSheet()->mergeCells('E12:I12');
    $objPHPExcel->getActiveSheet()->setCellValue('E12', "__________________________ " . $company_director);

    // styles for ОТЧЕТ ПО ПИТАНИЮ СПО ППССЗ & Отделение
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('H15')->applyFromArray($styleArray);

    // СВОДНЫЙ ОТЧЕТ ПО ПИТАНИЮ
    $objPHPExcel->getActiveSheet()->mergeCells('D14:G14');
    $objPHPExcel->getActiveSheet()->setCellValue('D14', "ОТЧЕТ ПО ПИТАНИЮ НПО");

    // Отделение
    $objPHPExcel->getActiveSheet()->mergeCells('H15:I15');
    $objPHPExcel->getActiveSheet()->setCellValue('H15', $company_department);

    // за ___ месяц ___ г.
    $objPHPExcel->getActiveSheet()->mergeCells('D15:G15');
    $objPHPExcel->getActiveSheet()->setCellValue('D15', "За  " . $month . "  месяц   " . $year . " г.");

    // styles for за ___ месяц ___ г.
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('D15')->applyFromArray($styleArray);


    $objPHPExcel->getActiveSheet()->setCellValue('B16', '№ п/п');
    $objPHPExcel->getActiveSheet()->setCellValue('C16', 'Дата');
    $objPHPExcel->getActiveSheet()->setCellValue('D16', 'Кол-во заказанных обедов в день');
    $objPHPExcel->getActiveSheet()->setCellValue('E16', 'Стоимость меню');
    $objPHPExcel->getActiveSheet()->setCellValue('F16', 'Стоимость меню со снижением');
    $objPHPExcel->getActiveSheet()->setCellValue('G16', 'Сумма в день');
    $objPHPExcel->getActiveSheet()->setCellValue('H16', 'Сумма в день со снижением');
    $objPHPExcel->getActiveSheet()->setCellValue('I16', 'Кол-во студентов на практике');

    // styles for table titles
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('B16')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B16'), 'B16:I16');
    $objPHPExcel->getActiveSheet()->getStyle('B16:I16')->getAlignment()->setWrapText(true);

// data
    $start = 17;
    $row = 17;
    $count = 1;
    $count_id = 1;
    $date_count = 0;
    while ($date_count < count($dates_in_month)){
        $current_date_sql = new DateTime($dates_in_month[$count-1]);
        $current_date_sql = (string)$current_date_sql->format('Y-m-d');
        $lunches = getNPOLunchOnday($current_date_sql);
        if($lunches > 0){
            $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row, $count_id);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row, $dates_in_month[$date_count]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row, $lunches);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row, $company_price);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row, ' ');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row, '=D' .(string)$row . "*E".(string)$row);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row, ' ');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row, ' ');

            $row++;
            $count_id++;
        }
        $count++;
        $date_count++;


    }
    $row_end = 47-$row;
    for ($row_space = $row; $row_space <= $row + $row_end; $row_space++){
        $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row_space, $count_id);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, ' ');
        $count++;
        $count_id++;
    }

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('B17')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B17'), 'B17:I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('B17:I' . (string)$row_space)->getAlignment()->setWrapText(true);


    // total
    $range = 'B' . (string)$row_space . ':C'. (string)$row_space;
//    var_dump($range);
    $objPHPExcel->getActiveSheet()->mergeCells($range);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$row_space, 'ИТОГО');
    $sum_end_point = $row_space-1;
    $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$row_space, '=SUM(D17:D' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$row_space, '=SUM(E17:E' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$row_space, ' ');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$row_space, '=SUM(G17:G' . (string)$sum_end_point .')');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$row_space, '');
    $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$row_space, '=SUM(I17:I' . (string)$sum_end_point .')');



    // styles for table total
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space ), 'B' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('B' . (string)$row_space . ':I'. (string)$row_space)->getAlignment()->setWrapText(true);

//    $created_date1 = new DateTime($date1);
//    $created_date2 = new DateTime($date2);
//
//
//    while($created_date1->format("Y-n") < $created_date2->format("Y-n")) {
//        $created_date1->setDate($created_date1->format("Y"), $created_date1->format("m"),$day1);
//        echo $created_date1->format("Y-m-d")."<br/>";
//        $created_date1->modify("+1 day");
//    }
    $row_names_start = $row_space+1;
    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Специалист по питанию ' . $company_name . '             _____________________/' . $company_responsible . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Зам.директора по управлению ресурсами ' . $company_name . '_____________________/' . $company_resource . '/');

    $row_space = $row_space+2;

    $objPHPExcel->getActiveSheet()->mergeCells('A' . (string)$row_space . ':I'. (string)$row_space);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$row_space, 'Заведующий отделением ' . $company_name . '_____________________/' . $company_manager . '/');

    // styles for table_body
    $styleArray = array(
        'font' => array(
            'bold' => false,
            'size' => 12,
            'name' => 'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );

    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start), 'A' . (string)$row_names_start . ':I' . (string)$row_space);
    $objPHPExcel->getActiveSheet()->getStyle('A' . (string)$row_names_start . ':I' . (string)$row_space)->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->setTitle("НПО");
    $objPHPExcel->setActiveSheetIndex(0);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    //$callEndTime = microtime(true);
    //$callTime = $callEndTime - $callStartTime;

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