<?php

// Include the main TCPDF library (search for installation path).
require_once('classes\tcpdf_min\tcpdf.php');

class MYPDF extends TCPDF
{

    public function ColoredTable($result)
    {
        $img_file = './img/header.png';
        $img_file1 = './img/footer.png';

        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
        $this->Image($img_file, 0, 0, 223, 40, '', '', '', false, 300, '', false, false, 0);
        $this->Image($img_file1, 0, 287, 223, 10, '', '', '', false, 300, '', false, false, 0);
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();
        $this->Ln();

        $color0 = "#efedf1";
        $color1 = "#ffffff";
        $colorDay = "black";
        $tbl = <<<EOD
        <br/><br/><br/><br/><br/><br/><br/><table cellpadding="5" border="1" width="100%">

        EOD;
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($i % 2 == 0)
                $color = $color1;
            else
                $color = $color0;
            $day = str_replace("-", ".", substr($result[$i]->date, -5));
            $day = explode(".", $day);
            $day = $day[1] . "." . $day[0];
            $date = $result[$i]->dayName . "<br/><b>" . $day . "</b>";
            if ($result[$i]->dayName == "niedziela")
                $colorDay = "red";
            else
                $colorDay = "black";

            $tbl .= '<tr bgcolor="' . $color . '" nobr="true" ><td color="' . $colorDay . '" width="22%" style="text-align: center; vertical-align: middle;">' . $date . '</td>';
            $intentionList = $result[$i]->intentionList;

            $intentionText = '';
            if (sizeof($intentionList > 0)) {
                for ($j = 0; $j < sizeof($intentionList); $j++) {
                    $intentionText .= '<b>' . substr($intentionList[$j]->date, 11, -12) . '</b> ' . $intentionList[$j]->text . '<br/>';
                }
            } else {
                $intentionText = 'Brak intencji na ten dzień';
            }

            $tbl .= '<td bgcolor="' . $color . '" width="78%">' . $intentionText . '</td> </tr>';
        }
        $tbl .= <<<EOD
        </table>
        EOD;

        $this->writeHTML($tbl, true, false, false, false, '');
    }
}