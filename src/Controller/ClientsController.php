<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Clients;
use App\Entity\Wallet;
/**
 * @Route("/clients", name="clients_")
 */
class ClientsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
        ]);
    }


    /**
     * @Route("/create", methods={"POST"}, name="clients")
     */
    public function registerClients(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        $data = json_decode($request->getContent(), true);

    	$client = new Clients();

    	$client->setDocumento($data['document']);

    	$client->setNombres($data['name']);

    	$client->setEmail($data['email']);

    	$client->setCelular($data['phone']);

    	$entityManager->persist($client);

    	$entityManager->flush();

    	$errors = $validator->validate($client);

        if (count($errors) > 0) {
            return new Response();

            $response->setContent(json_encode([
                'code' => 400,
                'error' => (string) $errors
            ]));
        }  

        $wallet = $this->walletCreate($client);

		if (!$wallet) {
			return new Response((string) "error interno al crear la billetera por favor intente mas tarde", 400);
		}

        $response = new Response();

        $response->setContent(json_encode([
        'code' => 200,
    ]));

        return $response;
    }

    public function walletCreate($id)
    {
    	$entityManager = $this->getDoctrine()
    					->getManager();

        $wallet = new Wallet();

        $wallet->setIdClient($id);

        $wallet->setBalance(0);

        $entityManager->persist($wallet);

    	$entityManager->flush();

        return true;
    }
}
