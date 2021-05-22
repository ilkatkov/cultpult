<?php

require_once '../../../vendor/autoload.php';
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";
session_start();

$state = getState($_SESSION['Username']);
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $state != "1") {
    /** Error reporting */
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);

    /** Include PHPExcel */
    require_once  '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';

    /** Include PHPExcel_IOFactory */
    require_once  '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

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
    $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

    // margins in INCH
    $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.35);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.31);
    $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.35);

    // A4 and orientation
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $objPHPExcel->getActiveSheet()->getPageSetup()
        ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    // column's width
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(19);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(26);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

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

    $date_sql = $_GET['date']; // дата в запросе
    $date = date("d.m.Y", strtotime($date_sql)); // дата в документе
    $date_current = date("d.m.Y");

    // get settings
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


    // main label
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ЖУРНАЛ');

    // styles for main label
    $styleArray = array(
        'font' => array(
            'bold'  =>  true,
            'size'  =>  16,
            'name'  =>  'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);


    // labels for company and date
    $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', 'заявок на питание ' . $company_name);

    $objPHPExcel->getActiveSheet()->mergeCells('F2:G2');
    $objPHPExcel->getActiveSheet()->setCellValue('F2', $date_current);

    $objPHPExcel->getActiveSheet()->mergeCells('H2:I2');
    $objPHPExcel->getActiveSheet()->setCellValue('H2', $company_department);

    // styles for company and date
    $styleArray = array(
        'font' => array(
            'bold'  =>  false,
            'size'  =>  16,
            'name'  =>  'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A2'), 'A2:I2');

    $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(7);
    $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(80);
    $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(22);

    $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Группа');
    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Ф.И.О. куратора');
    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Количество учащихся по списку');
    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Количество заявленных обедов (сухих пайков)');
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Количество студентов на  производственной практике (каникулах, сессии)');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Корректировка количество горячих обедов до 12 часов текущего дня');
    $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Фактическое количество студентов, получивших горячее питание');
    $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Количество невостребованных обедов');
    $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Подпись куратора');

    $objPHPExcel->getActiveSheet()->setCellValue('A5', '1');
    $objPHPExcel->getActiveSheet()->setCellValue('B5', '2');
    $objPHPExcel->getActiveSheet()->setCellValue('C5', '3');
    $objPHPExcel->getActiveSheet()->setCellValue('D5', '4');
    $objPHPExcel->getActiveSheet()->setCellValue('E5', '5');
    $objPHPExcel->getActiveSheet()->setCellValue('F5', '6');
    $objPHPExcel->getActiveSheet()->setCellValue('G5', '7');
    $objPHPExcel->getActiveSheet()->setCellValue('H5', '8');
    $objPHPExcel->getActiveSheet()->setCellValue('I5', '9');

    $current_row = 6;

    for ($row = 0; $row <= count($events) - 1; $row++) {

        $temp_event = $events[array_search($events[$row]['id'], array_column($events, 'id'))]['name'];
        $temp_time = $events[$row]['time'];
        $temp_curator = explode(" ", $events[array_search($events[$row]['id'], array_column($events, 'id'))]['curator']);
        $temp_curator = $temp_curator[0] . " " . substr($temp_curator[1], 0, 2) . "." . substr($temp_curator[2], 0, 2) . ".";
        $temp_code = getCodeOnTime($temp_time)[0]['id'];
        $temp_count = count(getparticipants($temp_code));

        $query_count = "SELECT COUNT(id) FROM `archive` WHERE date = '" . mysqli_real_escape_string($link, $date_sql) . "' AND events = '" . mysqli_real_escape_string($link, $temp_code) . "'";
        $count_sql = mysqli_query($link, $query_count);
        for ($count_data = []; $i = mysqli_fetch_assoc($count_sql); $count_data[] = $i);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$current_row, $temp_event);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . (string)$current_row, $temp_curator);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . (string)$current_row, $temp_count); // в группе
        $objPHPExcel->getActiveSheet()->setCellValue('D' . (string)$current_row, $count_data[0]["COUNT(id)"]); // кушает
        $objPHPExcel->getActiveSheet()->setCellValue('E' . (string)$current_row, '');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . (string)$current_row, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . (string)$current_row, $count_data[0]["COUNT(id)"]); // по факту
        $objPHPExcel->getActiveSheet()->setCellValue('H' . (string)$current_row, '');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . (string)$current_row, '');

        $objPHPExcel->getActiveSheet()->getRowDimension((string)$current_row)->setRowHeight(22);

        $current_row++;

    }

    $total_row = $current_row + 4;

    // fix height for spaces
    for ($row = $current_row; $row <= $total_row + 1; $row++){
        $objPHPExcel->getActiveSheet()->getRowDimension((string)$row)->setRowHeight(22);
    }

    $objPHPExcel->getActiveSheet()->setCellValue('A' . $total_row, 'ИТОГО');
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $total_row, '');
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $total_row, '=SUM(C6:C' . (string)$current_row . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $total_row, '=SUM(D6:D' . (string)$current_row . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $total_row, '');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $total_row, '');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $total_row, '=SUM(G6:G' . (string)$current_row . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $total_row, '');
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $total_row, '');

    $objPHPExcel->getActiveSheet()->getRowDimension((string)$total_row)->setRowHeight(22);

    // styles for table
    $styleArray = array(
        'font' => array(
            'bold'  =>  true,
            'size'  =>  12,
            'name'  =>  'Times New Roman'
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

    $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A4'), 'A4:I' . (string)$total_row);
    $objPHPExcel->getActiveSheet()->getStyle('A4:I' . (string)$total_row)->getAlignment()->setWrapText(true);

    // styles first and second columns
    $styleArray = array(
        'font' => array(
            'bold'  =>  true,
            'size'  =>  12,
            'name'  =>  'Times New Roman'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A6'), 'A6:B' . (string)$total_row);
    $objPHPExcel->getActiveSheet()->getStyle('A6:B' . (string)$total_row)->getAlignment()->setWrapText(true);


    $footer_start  = $total_row + 2;

    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$footer_start, 'Ответственный по питанию _____________________ ' . $company_responsible);

    $footer_end  = $footer_start + 3;

    $objPHPExcel->getActiveSheet()->setCellValue('A' . (string)$footer_end, 'И.о. Зав. отделением                 _______________________ ' . $company_manager);

    $styleArray = array(
        'font' => array(
            'bold'  =>  true,
            'size'  =>  16,
            'name'  =>  'Times New Roman'
        ),
    );

    $objPHPExcel->getActiveSheet()->getStyle('A' .(string)$footer_start)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A' .(string)$footer_start), "A" . (string)$footer_start . ":A" . (string)$footer_end);

    $objPHPExcel->getActiveSheet()->setTitle($date_current);
    $objPHPExcel->setActiveSheetIndex(0);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    //$callEndTime = microtime(true);
    //$callTime = $callEndTime - $callStartTime;

    $file_name = 'fl_' . $date . '.xlsx';
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