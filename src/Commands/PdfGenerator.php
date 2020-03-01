<?php
declare(strict_types=1);

namespace App\DigitalSign\Commands;

use App\DigitalSign\File\Path;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TCPDF;

class PdfGenerator extends Command
{
    /**
     * @var TCPDF
     */
    private $pdf;

    public function __construct(TCPDF $TCPDF, string $name = 'app:pdf-generate')
    {
        parent::__construct($name);
        $this->pdf = $TCPDF;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('generate starting...');

        // set certificate file
        $certificate = sprintf('file://%s', Path::basePath('output.crt'));
        $key = sprintf('file://%s', Path::basePath('output.key'));

        // set additional information
        $info = array(
            'Name'        => 'TCPDF',
            'Location'    => 'Office',
            'Reason'      => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );

        // set document signature
        $this->pdf->setSignature($certificate, $key, '123123', '', 2, []);

        // set font
        $this->pdf->SetFont('helvetica', '', 12);

        // add a page
        $this->pdf->AddPage();

        // print a line of text
        $text = 'This is a <b color="#FF0000">digitally signed document</b> using the default (example) <b>tcpdf.crt</b> certificate.<br />To validate this signature you have to load the <b color="#006600">tcpdf.fdf</b> on the Arobat Reader to add the certificate to <i>List of Trusted Identities</i>.<br /><br />For more information check the source code of this example and the source code documentation for the <i>setSignature()</i> method.<br /><br /><a href="http://www.tcpdf.org">www.tcpdf.org</a>';
        $this->pdf->writeHTML($text, true, 0, true, 0);

        // ---------------------------------------------------------

        //Close and output PDF document
        $this->pdf->Output(Path::basePath('storage/logs/example_052.pdf'), 'F');



        $output->writeln('generate completed...');

        return 0;
    }
}