<?php
declare(strict_types=1);

namespace App\Controller;

use App\Example\ExampleAggregate;
use App\Example\ExampleAggregateRootId;
use App\Example\Person;
use App\Example\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use EventSauce\EventSourcing\AggregateRootRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use function array_map;
use function array_push;
use function dump;

class WelcomeController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', methods: ["GET"], name: 'home')]
    public function index()
    {
        /** @var PersonRepository $repository */
        $repository = $this->entityManager->getRepository(Person::class);
        $ids = [];

        foreach ([1,2,3,4, 5, 6, 7, 8, 9] as $number) {
            $ids[$number] = Uuid::uuid4();
            $repository->store(new Person($ids[$number], 'Person ' . $number));
        }

        foreach ([[1,2], [2,3], [2,4], [1,4], [4,5], [4,7]] as [$from, $to]) {
            $from = $repository->find($ids[$from]);
            $to = $repository->find($ids[$to]);
            $from->addFriend($to);
            $to->addFriend($from);
            $repository->store($to);
            $repository->store($from);
        }

        return $this->render('index.html.twig');
    }

    #[Route('/increment/{uid}/{incrementBy}', methods: ["GET"], requirements: ['incrementBy' => '\d+'])]
    public function incrementNumber(
        string $uid,
        int $incrementBy,
        #[Autowire(service: 'example_aggregate_root_repository')]
        AggregateRootRepository $repository)
    {
        /** @var ExampleAggregate $aggregateRoot */
        $aggregateRoot = $repository->retrieve(ExampleAggregateRootId::fromString($uid));
        $aggregateRoot->incrementNumber($incrementBy);
        $repository->persist($aggregateRoot);

        return new JsonResponse([
            'status' => 'OK',
            'incrementBy' => $incrementBy,
            'total' => $aggregateRoot->total(),
        ]);
    }

    #[Route('/recommend-friends-for/{id}/')]
    public function recommendFriends(string $id)
    {
        /** @var PersonRepository $repository */
        $repository = $this->entityManager->getRepository(Person::class);
        $person = $repository->find(Uuid::fromString($id));
        $idsOfAllMyFriends = $person->idsOfAllMyFriends();
        $excludeThesePeople =  $idsOfAllMyFriends;
        $excludeThesePeople[] = $person->id();
        $fromPeople = $idsOfAllMyFriends;
        $collectedSuggestions = [];

        while(count($collectedSuggestions) < 15) {
            $suggestions = $repository->findConnectedToAndExcluding($fromPeople, $excludeThesePeople);

            if (count($suggestions) === 0) {
                break;
            }

            array_push($collectedSuggestions, ...$suggestions);

            // setting up for th next round
            $fromPeople = array_map(fn($p) => $p->id(), $suggestions);
            array_push($excludeThesePeople, $fromPeople);
        }

        return new JsonResponse($collectedSuggestions);
    }
}