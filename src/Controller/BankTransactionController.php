<?php

namespace App\Controller;

use App\Entity\BankTransaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BankTransactionType;


class BankTransactionController extends AppController
{
    /**
     * Add the transaction to the database
     *
     * @param Request $request
     * @return JsonResponse
     * @Route("/bank/transaction/add", name="bank_transaction_add", methods={"POST"})
     */
    public function addTransaction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $bankTransaction = new BankTransaction();
        $form = $this->createForm(BankTransactionType::class, $bankTransaction);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            try {
                $em->persist($bankTransaction);
                $em->flush();
            } catch (\Exception $e) {

                return $this->json([
                    'message'   =>  'error'
                ], JsonResponse::HTTP_BAD_REQUEST);
            }

            return $this->json([
                'message'   => 'success',
                'uuid'      => $bankTransaction->getUuid()
            ], JsonResponse::HTTP_OK);
        }
        
        return $this->json([
            'message'           => 'error',
            'form_validation'   => $this->formErrors($form)
        ], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     * @Route("/bank/transaction/{uuid}", name="bank_transaction_get")
     */
    public function getTransaction(Request $request, $uuid)
    {
        $em = $this->getDoctrine()->getManager();

        $bankTransaction = $em->getRepository(BankTransaction::class)->findOneBy(['uuid' => $uuid]);

        if(!$bankTransaction) {
            return $this->jsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }


        return $this->jsonResponse($bankTransaction, JsonResponse::HTTP_OK);
    }
}
