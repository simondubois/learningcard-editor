<?php
declare(strict_types=1);

namespace Simondubois\LearningCardEditor;

use Dompdf\Dompdf;
use Symfony\Component\Finder\SplFileInfo;

class Renderer
{
    public function render(array $content) : string
    {
        $dompdf = new DomPDF;
        $dompdf->loadHtml(json_encode($content));
        $dompdf->setPaper('A4', 'landscape');
        @$dompdf->render();
        return $dompdf->output();
    }
}
