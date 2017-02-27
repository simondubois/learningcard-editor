<?php
declare(strict_types=1);

namespace Simondubois\LearningCardEditor;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Finder\SplFileInfo;

class Renderer
{
    protected $cellPerPage = 10;
    protected $cellPerRow = 5;

    public function render(array $content) : string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($this->html($content));
        @$dompdf->render();
        return $dompdf->output();
    }

    protected function html(array $content) : string
    {
        return
            '<html>'
                .'<head>'
                    .'<style>'
                        .$this->style()
                    .'</style>'
                .'</head>'
                .'<body>'
                    .implode(
                        '',
                        array_map([$this, 'table'], array_chunk($content, $this->cellPerPage))
                    )
                .'</body>'
            .'</html>';
    }

    protected function style() : string
    {
        return <<<'ENDHTML'
            html {
                margin: 1cm 0cm;
            }
            table {
                border-collapse: collapse;
                margin: auto;
                border: 1px solid #ff8d15;
            }
            td {
                width: 5cm;
                height: 8cm;
                padding: 0.25cm;
                background: #edebe1;
                text-align: center;
            }
            img + p {
                padding: 0.25cm 0cm 0cm 0cm;
            }
            p {
                margin: 0cm;
                padding: 0.25cm;
                font-family: DejaVu Sans;
                color: #ff8d15;
            }
ENDHTML;
    }

    protected function table(array $content) : string
    {
        return
            '<table style="width: '.(5 * $this->cellPerRow).'cm;">'
                .implode(
                    '',
                    array_map([$this, 'frontRow'], array_chunk($content, $this->cellPerRow))
                )
            .'</table>'
            .'<div style="page-break-after: always;"></div>'
            .'<table style="width: '.(5 * $this->cellPerRow).'cm;">'
                .implode(
                    '',
                    array_map([$this, 'backRow'], array_chunk($content, $this->cellPerRow))
                )
            .'</table>'
            .'<div style="page-break-after: always;"></div>';
    }

    protected function frontRow(array $content) : string
    {
        return
            '<tr>'
                .implode('', array_map([$this, 'frontCell'], $content))
            .'</tr>';
    }

    protected function backRow(array $content) : string
    {
        return
            '<tr>'
                .implode('', array_reverse(array_map([$this, 'backCell'], $content)))
            .'</tr>';
    }

    protected function frontCell(array $item) : string
    {
        return
            '<td>'
                .'<img src="'.$item[0].'">'
                .'<p>'
                    .($item[1] ?? '')
                .'</p>'
            .'</td>';
    }

    protected function backCell(array $item) : string
    {
        return
            '<td style="background: #4c4c45;">'
                .'<p style="font-weight: bold; color: #edebe1;">'
                    .($item[2] ?? '')
                .'</p>'
            .'</td>';
    }
}
