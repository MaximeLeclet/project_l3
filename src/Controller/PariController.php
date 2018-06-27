<?php

namespace App\Controller;


use App\Entity\Pari;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PariController extends Controller
{

    function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paris = $em->getRepository("App\Entity\Pari")->findAll();

        return $this->render("Pari/index.html.twig", array('paris' => $paris));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    function newAction(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security_login');
        }

        $em = $this->getDoctrine()->getManager();

        // just setup a fresh $post object (remove the dummy data)
        $pari = new Pari();

        $urls = explode('/', $request->getUri());
        $equipe_1 = $urls[5];
        $equipe_2 = $urls[6];

        $form = $this->createFormBuilder($pari)
            ->add('equipe1', TextType::class, array('label' => 'Equipe No 1', 'data' => $equipe_1))
            ->add('equipe2', TextType::class, array('label' => 'Equipe No 2', 'data' => $equipe_2))
            ->add('score_equipe1', NumberType::class)
            ->add('score_equipe2', NumberType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pari = $form->getData();

            $pari->setUser($this->getUser());

            $em->persist($pari);
            $em->flush();

            $userParis = $em->getRepository("App\Entity\Pari")->findBy([
                'user' => $this->getUser()
            ]);

            //$datas =  json_decode($this->mooc(),true);
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'http://daudenthun.fr/api/listing');
            $datas = json_decode($res->getBody(), true);
            $livescore = array();
            $i = 0;
            foreach ($datas as $teams) {
                foreach ($teams as $team => $match) {
                    $livescore[$i]['team1'] = $team;
                    $livescore[$i]['team2'] = $match['vs'];
                    $livescore[$i]['score1'] = $match['score'][0];
                    $livescore[$i]['score2'] = $match['score'][1];
                    $livescore[$i]['date'] = \DateTime::createFromFormat('d/m/Y', $match['date']);
                    $livescore[$i]['live'] = $match['live'];

                    $pointsgagnes = 0;
                    foreach ($userParis as $uP => $onePari) {
                        if ($onePari->getEquipe1() == $team AND $onePari->getEquipe2() == $match['vs']) {
                            if ($onePari->getScoreEquipe1() == $match['score'][0] AND $onePari->getScoreEquipe2() == $match['score'][1]) {
                                $pointsgagnes = 20;
                            } elseif (($match['score'][0] < $match['score'][1] AND $onePari->getScoreEquipe1() < $onePari->getScoreEquipe2())
                                OR ($match['score'][0] > $match['score'][1] AND $onePari->getScoreEquipe1() > $onePari->getScoreEquipe2())) { // On a le bon vainqueur
                                $pointsgagnes = 5;
                            }
                        }
                    }
                    $livescore[$i]['pointsgagnes'] = $pointsgagnes;
                    $this->getUser()->setPoints($this->getUser()->getPoints() + $pointsgagnes);
                }
                $i++;
            }

            return $this->render("Matchs/index.html.twig", array(
                'user' => $this->getUser(),
                'userParis' => $userParis,
                'results' => $livescore
            ));
        }

        return $this->render('Pari/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    function ModifAction(Request $request)
    {
        $urls = explode('/', $request->getUri());
        $id = $urls[5];

        $em = $this->getDoctrine()->getManager();

        $currentPari = $em->getRepository("App\Entity\Pari")->findOneBy([
            'id' => $id
        ]);

        $newPari = new Pari();

        $form = $this->createFormBuilder($newPari)
            ->add('equipe1', TextType::class, array('label' => 'Equipe No 1', 'data' => $currentPari->getEquipe1()))
            ->add('equipe2', TextType::class, array('label' => 'Equipe No 2', 'data' => $currentPari->getEquipe2()))
            ->add('score_equipe1', IntegerType::class, array('label' => 'Score Equipe No 1', 'data' => $currentPari->getScoreEquipe1()))
            ->add('score_equipe2', IntegerType::class, array('label' => 'Score Equipe No 1', 'data' => $currentPari->getScoreEquipe2()))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formDatas = $form->getData();

            $currentPari->setScoreEquipe1($formDatas->getScoreEquipe1());
            $currentPari->setScoreEquipe2($formDatas->getScoreEquipe2());
            $currentPari->setUser($this->getUser());

            $em->persist($currentPari);
            $em->flush();

            $userParis = $em->getRepository("App\Entity\Pari")->findBy([
                'user' => $this->getUser()
            ]);

            //$datas =  json_decode($this->mooc(),true);
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'http://http://daudenthun.fr/api/listing');
            $datas =  json_decode($res->getBody(),true);
            $livescore = array();
            $i = 0;
            foreach ($datas as $teams){
                foreach ($teams as $team =>$match){
                    $livescore[$i]['team1'] = $team;
                    $livescore[$i]['team2'] = $match['vs'];
                    $livescore[$i]['score1'] = $match['score'][0];
                    $livescore[$i]['score2'] = $match['score'][1];
                    $livescore[$i]['date'] = \DateTime::createFromFormat('d/m/Y',$match['date']);
                    $livescore[$i]['live'] = $match['live'];
                }
                $i++;
            }

            return $this->render('Matchs/index.html.twig', array(
                'user'=>$this->getUser(),
                'userParis'=>$userParis,
                'results'=>$livescore
            ));
        }

        return $this->render('Pari/modif.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}