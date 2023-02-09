<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelPanierController extends AbstractController
{
    private $session;
    private $repo;

    public function __construct(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $this->session = $session;
        $this->repo = $articleRepository;
    }

    /**
     * permet de recupérer les éléments du panier
     */
    private function getData(): array
    {
        $panier = $this->session->get('panier', []);
        $list = [];
        foreach ($panier as $id => $quantity) {
            $list[] = [
                'name' => $this->repo->find($id)->getName(),
                'designation' => $this->repo->find($id)->getName(),
                'quantity' => $quantity
            ];
        }
        return $list;
    }

    /**
     * Permet à l'admin de pouvoir exporter son panier au format excel
     * @Route("/panier/excel",  name="panier_excel")
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function export(): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Liste des articles');

        $sheet->getCell('C2')->setValue('Bon de commande');
        $spreadsheet->getActiveSheet()->getStyle('C2')->getFont()->setName('Souvenir Lt BT');
        $spreadsheet->getActiveSheet()->mergeCells('C2:H2');
        $spreadsheet->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C2')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //$spreadsheet->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $spreadsheet->getActiveSheet()->getStyle('C2:H2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('90EE90');
        $spreadsheet->getActiveSheet()->getStyle('C2')->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getRowDimension('15')->setRowHeight(7);
        $spreadsheet->getActiveSheet()->getRowDimension('18')->setRowHeight(4);
        $sheet->getCell('E4')->setValue('STé:');
        $spreadsheet->getActiveSheet()->mergeCells('E4:E5');
        $sheet->getCell('E6')->setValue('Adr:');
        $sheet->getCell('E7')->setValue('CP:');
        $sheet->getCell('E8')->setValue('Ville:');
        $sheet->getCell('E9')->setValue('TEL:');
        $sheet->getCell('E10')->setValue('Fax:');
        $spreadsheet->getActiveSheet()->mergeCells('F4:G4');
        $spreadsheet->getActiveSheet()->mergeCells('F5:G5');
        $spreadsheet->getActiveSheet()->mergeCells('F6:G6');
        $spreadsheet->getActiveSheet()->mergeCells('F7:G7');
        $spreadsheet->getActiveSheet()->mergeCells('F8:G8');
        $spreadsheet->getActiveSheet()->mergeCells('F9:G9');
        $spreadsheet->getActiveSheet()->mergeCells('F10:G10');
        $spreadsheet->getActiveSheet()->getStyle('E4:E10')->getFont()->setName('Souvenir Lt BT');
        $spreadsheet->getActiveSheet()->getStyle('E4:E10')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('E4:E10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth('5');
        $sheet->getCell('C9')->setValue('Adresse de la société - Code Postal Ville');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth('33');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $sheet->getCell('C10')->setValue('Tél : xx.xx.xx.xx.xx  -  Fax : xx.xx.xx.xx.xx');
        $spreadsheet->getActiveSheet()->mergeCells('C13:C14');
        $sheet->getCell('C13')->setValue('Emetteur');
        $spreadsheet->getActiveSheet()->getStyle('C13')->getFont()->setBold('true');
        $spreadsheet->getActiveSheet()->getStyle('C13')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->mergeCells('E13:F13');
        $spreadsheet->getActiveSheet()->mergeCells('G13:H13');
        $sheet->getCell('E13')->setValue('Transmis le:');
        $sheet->getCell('E14')->setValue('Degrés d\'urgence 1 ou 2 ou 3');
        $spreadsheet->getActiveSheet()->getStyle('E14')->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('D13:D14')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFF00');
        $spreadsheet->getActiveSheet()->getStyle('G13')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFF00');
        $spreadsheet->getActiveSheet()->getStyle('H14')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFF00');

        $spreadsheet->getActiveSheet()->mergeCells('C16:C17');
        $spreadsheet->getActiveSheet()->mergeCells('D16:D17');
        $sheet->getCell('C16')->setValue('Nom du responsable');
        $spreadsheet->getActiveSheet()->getStyle('C16')->getFont()->setBold('true');
        $spreadsheet->getActiveSheet()->getCell('D16')->getHyperlink()->setUrl('info@eh');
        $sheet->getCell('D16')->setValue('info@eh');
        $spreadsheet->getActiveSheet()->getStyle('C16:D17')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C16:D17')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->mergeCells('E16:F16');
        $spreadsheet->getActiveSheet()->mergeCells('G16:H16');
        $spreadsheet->getActiveSheet()->mergeCells('E17:F17');
        $spreadsheet->getActiveSheet()->mergeCells('G17:H17');
        $sheet->getCell('E16')->setValue('Devis N°');
        $sheet->getCell('E17')->setValue('Commande N°');
        $spreadsheet->getActiveSheet()->getStyle('E16:F17')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('E16:F17')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getCell('C19')->setValue('Code article');
        $sheet->getCell('D19')->setValue('Désignation');
        $sheet->getCell('E19')->setValue('Qté');
        $sheet->getCell('F19')->setValue('PU HT');
        $sheet->getCell('G19')->setValue('PT HT');
        $sheet->getCell('H19')->setValue('PT TTC');
        $spreadsheet->getActiveSheet()->getStyle('C19:H19')->getFont()->setBold('true');
        $spreadsheet->getActiveSheet()->mergeCells('C48:F48');
        $spreadsheet->getActiveSheet()->mergeCells('C49:F49');
        $sheet->getCell('C48')->setValue('Frais de port');
        $sheet->getCell('C49')->setValue('Total');
        $spreadsheet->getActiveSheet()->getStyle('C48:F49')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C48:F49')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('C48:F49')->getFont()->setBold('true');


        $styleArray = [

            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $styleArray2 = [
            'borders' => [
                'horizontal' => [
                    'borderStyle' => Border::BORDER_MEDIUMDASHED,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $styleArray3 = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $styleArray4 = [
            'borders' => [
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $styleArray5 = [

            'borders' => [
                'vertical' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('C13:H14')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C19:H49')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C16:H17')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C2:H2')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('d13:H14')->applyFromArray($styleArray2);
        $spreadsheet->getActiveSheet()->getStyle('E4:G11')->applyFromArray($styleArray3);
        $spreadsheet->getActiveSheet()->getStyle('E16:H17')->applyFromArray($styleArray4);
        $spreadsheet->getActiveSheet()->getStyle('C19:H46')->applyFromArray($styleArray5);
        $spreadsheet->getActiveSheet()->getStyle('C46:H46')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('G47:G49')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('G47:G49')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('G49:H49')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('C19:H19')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        // incrémente le curseur après avoir écrit l'en-tête
        $sheet->fromArray($this->getData(), null, 'C20', true);

        $writer = new Xlsx($spreadsheet);

/*        $writer->save('Liste articles.xlsx');

        return $this->redirectToRoute('panier_index');*/
        $fileName = 'Liste articles.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}