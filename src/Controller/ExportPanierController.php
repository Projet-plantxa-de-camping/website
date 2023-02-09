<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportPanierController extends PanierController
{
    /**
     * @Route("/panier/pdf", name="panier_pdf")
     * @param SessionInterface $session
     * @param ArticleRepository $repo
     */
    public function pdf(SessionInterface $session, ArticleRepository $repo): void
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancie Dompdf avec nos options
        $dompdf = new Dompdf($pdfOptions);

        $panier = $session->get('panier', []);
        foreach ($panier as $id => $quantite) {
            $panierWithData[] = [
                'id'=>$id,
                'article' => $repo->find($id),
                'quantite' => $quantite
            ];
        }

//        dd($panierWithData);
        $html = $this->render('panier/pdf.html.twig', [
            'items' => $panierWithData
        ]);
        // Dompdf récupère le HTML généré
        $dompdf->loadHtml($html);

        // (Optionnel) mise en page
        $dompdf->setPaper('A4', 'portrait');

        // HTML mis en PDF
        $dompdf->render();

        // générer le pdf sous forme de fichier à télécharger ("Attachment" => true) si false le pdf s'ouvre dans le navigateur
        $dompdf->stream("liste.pdf", [
            "Attachment" => true
        ]);
    }

}