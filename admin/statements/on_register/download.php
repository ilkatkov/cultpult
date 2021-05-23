<?php
require '../../../vendor/autoload.php';
include_once "../../../functions/xml.php";
include_once "../../../functions/mysql.php";

session_start();

$state = getState($_SESSION['Username']);
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    
    $link = connectDB();

    $event_name = $_POST['select_events'];
//    var_dump($event_name);
    $date_sql = $_POST['date'];
//    var_dump($date_sql);
    $date = date("d.m.Y", strtotime($date_sql)); // дата в документе
    $curator = getCuratorOnName((string)$event_name);
    $name_arr = explode(" ", $curator);
    $fio = $name_arr[0] . " " . substr($name_arr[1], 0, 2) . "." . substr($name_arr[2], 0, 2) . ".";

    // создаем документ Word
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultFontName('Times New Roman');
    $phpWord->setDefaultFontSize(14);

    $properties = $phpWord->getDocInfo();
    $properties->setCreator('КультПульт');
    $properties->setCompany('КультПульт');
    $properties->setLastModifiedBy('КультПульт');

    $sectionStyle = array(
        'orientation' => 'portrait',
        'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
        'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
        'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3),
        'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
    );
    $section = $phpWord->addSection($sectionStyle);

    // шапка
    $section->addText(htmlspecialchars("КультПульт"), array(), array('align' => 'center'));
    $statement = "Ведомость зарегистрировавшихся на мероприятие";
    $section->addText(htmlspecialchars($statement), array(), array('align' => 'center'));
    $statement = $event_name . " / " . $date;
    $section->addText(htmlspecialchars($statement), array(), array('align' => 'center'));
    $text = "";
    $section->addText(htmlspecialchars($text), array(), array('align' => 'center', 'space' => array('before' => 0, 'after' => 0)));

    // таблица
    $TableStyleName = 'Ведомость';
    $TableStyle = array('borderSize' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
    $TableCellStyle = array('valign' => 'center');
    $TableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
    $TableFontStyle = array('bold' => false);
    $phpWord->addTableStyle($TableStyleName, $TableStyle);
    $table = $section->addTable($TableStyleName);
    $table->addRow();
    $n_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2);
    $participant_width = \PhpOffice\PhpWord\Shared\Converter::cmToTwip(8);

    $table->addCell($n_width, $TableCellStyle)->addText('№ п/п', array(), array('align' => 'center'), $TableFontStyle);
    $table->addCell($participant_width, $TableCellStyle)->addText('ФИО Участника', array(), array('align' => 'center'), $TableFontStyle);
    $number = 1;
    $participants = getRegisterParticipants($event_name);
//    var_dump($participants);
    for ($row = 0; $row <= count($participants) - 1; $row++) {
        $temp_participant = $participants[$row]['surname'] . " " . substr($participants[$row]['name'], 0, 2) . "." . substr($participants[$row]['patronymic'], 0, 2) . ".";
        $temp_code = $participants[$row]['id'];
        $temp_event = (string)getparticipantInfo($temp_code)[0]['events'];
        $table->addRow();
        $table->addCell($n_width)->addText($number, array(), array('align' => 'center'));
        $table->addCell($participant_width)->addText(mb_convert_encoding($temp_participant, "UTF-8"), array(), array('align' => 'center'));
        $number++;
        }


    // сохранение и скачивание файла
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $file_name =  '_' . $date . '.docx';
    $objWriter->save('../../../storage/register/' . $file_name);
    header("Content-Length: " . filesize('../../../storage/register/' . $file_name));
    header("Content-Disposition: attachment; filename=" . $file_name);
    header("Content-Type: application/x-force-download; name=\"" . '../../../storage/register/' . $file_name . "\"");
    readfile('../../../storage/register/' . $file_name);
    ?>
        <form>
            <p class="login_mes">Возврат на главную...</p>
<!--            <meta http-equiv='refresh' content='1;../../index.php'>-->
        </form>
    <?php
    }
    ?>