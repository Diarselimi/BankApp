<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 2019-01-27
 * Time: 01:49
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppController extends AbstractController
{
    protected function jsonResponse($data, $statusCode = JsonResponse::HTTP_OK, $format = "json", $circularReference = 1)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function($data, $format, $context = []){ return $data->getId(); });

        $serializer = new Serializer([$normalizer], [$encoder]);

        return new JsonResponse(json_decode($serializer->serialize($data, $format)), $statusCode);

    }

    protected function formErrors(FormInterface $form)
    {
        $fields = [];
        foreach ($form->all() as $key => $child /** @var Form $child */) {
            $message = (string) $child->getErrors();
            if(!empty($message)) {
                $fields[$key] = $message;
            }

            foreach ($child as $item/** @var Form $item */) {
                foreach ($item->all() as $subKey => $subChild) {
                    $subMessage = (string) $subChild->getErrors();
                    if(!empty($subMessage)) {
                        $fields[$key][$subKey] = $subMessage;
                    }
                }
            }

        }

        return $fields;
    }

}