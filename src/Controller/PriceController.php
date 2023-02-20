<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductPriceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    #[Route('/price', name: 'app_price')]
    public function index(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductPriceType::class, $product,
//            [
//            'action' => $this->generateUrl('calculate'),
//            'method' => 'POST',
//            ]
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            match ($product->getName()){
                'headphones' => $product->setPrice(100),
                'case' => $product->setPrice(20),
            };
            $product = $this->calculatePrice($product);

            return $this->render('price/index.html.twig', [
                'form' => $form,
                'product' => $product,
            ]);
        }

        return $this->render('price/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/price/calculate', name: 'calculate')]
    public function calculatePrice(Product $product) : Product
    {
        $country = substr($product->getTaxNumber(), 0, 2);

        return match ($country){
            'DE' => $product->setPrice($product->getPrice() * 1.19),
            'IT' => $product->setPrice($product->getPrice() * 1.22),
            'GR' => $product->setPrice($product->getPrice() * 1.24),
        };
    }
}
