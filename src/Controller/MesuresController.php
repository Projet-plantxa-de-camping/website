<?php

namespace App\Controller;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesuresController extends AbstractController
{
    /**
     * @Route("/mesures", name="mesures")
     */
    public function index(ChartBuilderInterface $chartBuilder,HttpClientInterface $httpClient): Response
    {
        $mesures_temp = $httpClient->request('GET', 'http://127.0.0.1:8001/api/mesures?libelle=temperature_champ')->toArray();
        $mesures_temp2 = $httpClient->request('GET', 'http://127.0.0.1:8001/api/mesures?libelle=temperature_serre')->toArray();
        $mesures_humidity2 = $httpClient->request('GET', 'http://127.0.0.1:8001/api/mesures?libelle=humidite_serre')->toArray();
        $mesures_humidity = $httpClient->request('GET', 'http://127.0.0.1:8001/api/mesures?libelle=humidite_champ')->toArray();

        $labels_humidty=[];
        $labels_humidty2=[];

        $data_humidity=[];
        $data_humidity2=[];

        foreach ($mesures_humidity as $mesure){
            $data_humidity[]=$mesure["valeur"];
            $labels_humidty[]=date(" H:i",strtotime($mesure["createdAt"]));
        }

        foreach ($mesures_temp as $mesure)
        {
            $data_temp[]=$mesure["valeur"];
            $labels_temp[]=date(" H:i",strtotime($mesure["createdAt"]));
        }

        foreach ($mesures_humidity2 as $mesure2){
            $data_humidity2[]=$mesure2["valeur"];
            $labels_humidty2[]=date(" H:i",strtotime($mesure2["createdAt"]));
        }

        foreach ($mesures_temp2 as $mesure2){
            $data_temp2[]=$mesure2["valeur"];
            $labels_temp2[]=date(" H:i",strtotime($mesure2["createdAt"]));
        }

        // humidté champ
        $chart_humidity = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart_humidity->setData([
            'labels' => $labels_humidty,
            'datasets' => [
                [
                    'label' => 'humidité champ',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(24, 188, 156',
                    'data' => $data_humidity,
                ],
            ],
        ]);

        // humidté champ
        $chart_humidity2 = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart_humidity2->setData([
            'labels' => $labels_humidty2,
            'datasets' => [
                [
                    'label' => 'humidité serre',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(24, 188, 156',
                    'data' => $data_humidity,
                ],
            ],
        ]);

        $chart_humidity->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]);

        //temperature champ
        $chart_temp = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart_temp->setData([
            'labels' => $labels_temp,//axe des abscisses X(heure des données)
            'datasets' => [
                [
                    'label' => 'temperature champ', //nom du graphique
                    'backgroundColor' => 'rgb(44, 62, 80)', //couleur du fond du graphique
                    'borderColor' => 'rgb(255, 99, 132)',  //couleur des bords du graphique
                    'data' => $data_temp, //axe des ordonnées Y (mesure)
                ],
            ],
        ]);

        $chart_temp->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],//taille de l'axe
                ],
            ],
        ]);

        $chart_temp = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart_temp->setData([
            'labels' => $labels_temp,
            'datasets' => [
                [
                    'label' => 'temperature champ',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data_temp,
                ],
            ],
        ]);

        $chart_temp->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]);

        $chart_temp2 = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart_temp2->setData([
            'labels' => $labels_temp2,
            'datasets' => [
                [
                    'label' => 'temperature serre',
                    'backgroundColor' => 'rgb(44, 62, 80)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data_temp2,
                ],
            ],
        ]);

        $chart_temp2->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]);

        return $this->render('mesures/index.html.twig', [
            'chart1' => $chart_humidity,
            'chart2' => $chart_temp,
            'chart3' => $chart_humidity2,
            'chart4' => $chart_temp2

        ]);
    }
}
