<?php

// Include the main TCPDF library (search for installation path).
require_once('classes\tcpdf_min\tcpdf.php');

class MYPDF extends TCPDF
{

    public function ColoredTable($result)
    {
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('', '');

        $this->Cell(180, 0, 'INTENCJE PARAFIALNE', 0, 0, 'C', 0);
        $this->Ln();
        $this->Cell(180, 0, '', 0, 0, 'C', 0);
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        for ($i = 0; $i < sizeof($result); $i++) {
            $day = str_replace("-", ".", substr($result[$i]->date, -5));
            $day = explode(".", $day);
            $day = $day[1] . "." . $day[0];
            $date = $result[$i]->dayName . "\n" . $day;
            $this->MultiCell(50, 25, $date, 1, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');  //   $this->Cell(50, 35, 'o kurwa', 1, 0, 'C', 0);
            $this->MultiCell(130, 25, "<b>08:00</b> + Za Jana w 10 rocznicę śmierci z okazji urodzin, z prośbą o dalsze zdrowie i Boże błogosławieństwo w miłosiernym Bogu<br><b>08:00</b> + Za Jana<br><b>08:00</b> + Za Jana<br><b>08:00</b> + Za Jana", 1, 'L', 0, 0, '', '', true, 0, true); // $this->Cell(130, 35, 'Za janosisa', 1, 0, 'L', 0);
            $this->Ln();
        }
        $this->Cell(180, 0, '', 'T');
    }
}