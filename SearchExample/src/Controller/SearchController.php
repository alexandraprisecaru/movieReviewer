<?php

namespace App\Controller;

use Elastica\Query;
use Elastica\Suggest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Psr\Log\LoggerInterface;


class SearchController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param RepositoryManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, RepositoryManagerInterface  $manager): Response
    {
        $form =$this->createFormBuilder(null, [
            'attr' =>[
                'style'=>'margin:10px; display:inline-flex',
                'class'=>'form-inline' ]
        ])
            ->add('query', TextType::class, [
                'label' => false,
                'attr' =>[
                    'style'=>'width:500px;',
                    'class'=>'form-control mr-sm-1 col-lg',
                    'placeholder'=>"Search..." ]
            ])
            ->add('search', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-outline-success my-2 my-sm-0'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $searchedKeyword = $form->get('query')->getData();
            $movies = $this->getMovies($searchedKeyword, $manager);

            return $this->redirectToRoute('movie_index', [
                'movies'=> $movies 
            ]);
        }

        return $this->render('search/searchBar.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    public function searchBar(Request $request): Response
    {
        $form =$this->createFormBuilder(null, [
            'attr' =>[
                'style'=>'margin:10px; display:inline-flex;',
                'class'=>'form-inline' ]
        ])
            ->add('query', TextType::class, [
            'label' => false,
            'attr' =>[
                'style'=>'width:500px;',
                'class'=>'form-control mr-sm-1 col-lg',
                'placeholder'=>"Search..." ]
        ])
        ->add('search', SubmitType::class, [
            'attr'=>[
                'class'=>'btn btn-outline-success my-2 my-sm-0'
            ]
        ])
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $searchedKeyword = $form->get('query');

           // $a = getMovies($searchedKeyword);
            return $this->redirectToRoute('movie_index');
        }

        return $this->render('search/searchBar.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param string $searchedKeyword
     * @param RepositoryManagerInterface $manager
     * @return array
     */
  public function getMovies(string $searchedKeyword, RepositoryManagerInterface  $manager)
  {
    $completion = new Suggest\Completion('search', 'name_suggest');
    $completion->setText($searchedKeyword);
    $completion->setFuzzy(array('fuzziness' => 2));

    // $idk = $manager->getRepository('Movie')->find(($searchedKeyword));
    $completion = new Suggest\Completion('search', 'name_suggest');
    $completion->setText($searchedKeyword);
    $completion->setFuzzy(array('fuzziness' => 2));
    $resultSet = $manager->getRepository('App:Movie')->find(Query::create($completion));
    // $this->logger->info((String)$resultSet->count());
    foreach($resultSet as $result){
        // $this->logger->info($result);
        echo($result);
    }

    
    // $resultSet = $this->get('fos_elastica.index.app.movie')->search(Query::create($completion));
    // $suggestions = array();
    // foreach ($resultSet->getSuggests() as $suggests) {
    //   foreach ($suggests as $suggest) {
    //     foreach ($suggest['options'] as $option) {
    //       $suggestions[] = array(
    //         'id' => $option['_source']['id'],
    //         'text' => $option['_source']['name']
    //       );
    //     }
    //   }
    // }

    return $resultSet;
    // return new JsonResponse(array(
    //   'movies' => $resultSet,
    // ));
}

}
