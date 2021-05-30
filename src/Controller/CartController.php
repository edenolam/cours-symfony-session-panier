<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService): RedirectResponse
    {
        $cartService->add($id);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/panier/edit/{id}", name="cart_edit")
     */
    public function edit($id, CartService $cartService): RedirectResponse
    {
        $cartService->edit($id);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService): RedirectResponse
    {
        $cartService->remove($id);
        return $this->redirectToRoute('cart_index');
    }
}
