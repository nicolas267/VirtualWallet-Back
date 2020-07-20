<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Wallet;
use App\Entity\Clients;
use App\Entity\Tokens;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
* @Route("/wallet", name="wallet")
*/
class WalletController extends AbstractController
{
    /**
     * @Route("/recharge", methods={"POST"}, name="recharge")
     */
    public function recharge(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $client = $this->getDoctrine()
            ->getManager()
            ->getRepository(Clients::class)
            ->findByFieldCelular($data['document'], $data['phone']);
            

        if ($client === null) {
        	return new Response('Documento o celular errado por favor intente de nuevo', 400);
        }

        $wallet = $entityManager->getRepository(Wallet::class)->findOneByIdClient($client->getId());

        $wallet->setBalance($wallet->getBalance() + $data['balance']);

   		$entityManager->flush();

        $response = new Response();

        $response->setContent(json_encode([
            'code' => 200,
        ]));

        return $response;
    }

    /**
     * @Route("/pay", name="pay")
     */
    public function pay(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $data = json_decode($request->getContent(), true);

    	$client = $this->getDoctrine()
            ->getManager()
            ->getRepository(Clients::class)
            ->findByFieldEmail($data['document'], $data['email']);

        if ($client === null) {
            return new Response('Documento o celular errado por favor intente de nuevo', 400);
        }

        $wallet = $entityManager->getRepository(Wallet::class)->findOneByIdClient($client->getId());

        $token = $this->generateToken($client);

        $wallet->setConfirmPay($data['pay']);

        $entityManager->flush();

        $email = (new Email())
            ->from('hello@example.com')
            ->to('nicolasbolivar2679@gmail.com')
            ->replyTo('nicolasbolivar1916@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html("<p>http://127.0.0.1:8000/$token</p>");

        // $mailer->send($email);

        $response = new Response();

        $response->setContent(json_encode([
            'code' => 200,
            'token' => $token,
        ]));

        return $response;
    }

    /**
     * @Route("/pay/{token}", name="confirmPay")
     */
    public function confirmPay($token, EntityManagerInterface $entityManager)
    {
    	$token = $entityManager->getRepository(Tokens::class)->findOneByToken($token);

		if ($token === null) {
			return new Response('Token no valido', 400);
		}

    	$wallet = $entityManager->getRepository(Wallet::class)->findOneByIdClient($token->getClientId());

    	$balance = $wallet->getBalance();

    	$charges = $wallet->getConfirmPay();

    	$wallet->setBalance($balance - $charges);

    	$wallet->setConfirmPay(0);

    	$token->setSecretId(null);

    	$entityManager->flush();

        return new Response('Se ha confirmado su pago por favor cierre esta ventana');
    }

    public function generateToken($client)
    {
    	$entityManager = $this->getDoctrine()
    					->getManager();

    	$random = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 6);

    	$token = new Tokens();

    	$token->setClientId($client);

    	$token->setSecretId($random);

    	$entityManager->persist($token);

    	$entityManager->flush();

    	return $token->getSecretId();
    }
}
