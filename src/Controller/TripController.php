<?php

namespace App\Controller;

use App\Entity\TrackPoint;
use App\Entity\Trip;
use App\Form\TripFormType;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    /**
     * @Route("/trips", name="app_trips")
     */
    public function trips(TripRepository $tripRepository): Response
    {
        $trips = $tripRepository->findBy(['user'=>$this->getUser()]);
        return $this->render('trip/trips.html.twig', ['trips'=>$trips]);
    }


    /**
     * @Route("/trips/add", name="app_trips_add")
     */
    public function addTrip(Request $request): Response
    {
        $trip = new Trip();
        $form = $this->createForm(TripFormType::class, $trip);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $gpxFile */
            $gpxFile = $form->get('gpx_file')->getData();
            $gpx = simplexml_load_file($gpxFile->getRealPath());
            if($gpx!=false) {
                $entityManager = $this->getDoctrine()->getManager();
                if (isset($gpx->trk) && isset($gpx->trk->trkseg)) {
                    foreach ($gpx->trk->trkseg as $trkseg)
                        foreach ($trkseg->trkpt as $pt) {
                            $point = new TrackPoint();
                            $point->setTrip($trip)->setLat($pt['lat'])->setLon($pt['lon'])->setEle(isset($pt->ele) ? $pt->ele : 0)->setTime(new \DateTime($pt->time));
                            $entityManager->persist($point);
                        }
                }else return $this->render('trip/add.html.twig', [
                    'newForm' => $form->createView(),
                    'error' => 'Invalid GPX data!'
                ]);
                unset($gpx);
                $trip->setUser($this->getUser());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trip);
                $entityManager->flush();
            }else return $this->render('trip/add.html.twig', [
                'newForm' => $form->createView(),
                'error' => 'Invalid GPX data!'
            ]);
            return $this->redirect($this->generateUrl('app_trips'));
        }

        return $this->render('trip/add.html.twig', [
            'newForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trips/{trip}", name="app_trip")
     */
    public function trip(int $trip,TripRepository $tripRepository): Response
    {

        $trip = $tripRepository->findOneBy(['id'=>$trip]);
        $firstPoint = $trip->getTrackPoints()->first();
        // center map on starting point
        $center = $firstPoint->getLat().",".$firstPoint->getLon();
        foreach($trip->getTrackPoints() as $point)
            $points[]='['.$point->getLat().','.$point->getLon().','.$point->getEle().']';
        return $this->render('trip/trip.html.twig', ['trip'=>$trip,'center'=>$center,'gpx_points'=>implode(",",$points)]);
    }

}
