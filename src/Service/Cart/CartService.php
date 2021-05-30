<?php


namespace App\Service\Cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;

    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
    {
        // recuperer le panier, soit plein, soit nouveau panier vide
        $panier = $this->session->get('panier', []);

        // si j'ai deja un produit avec cet identifiant dans mon panier
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }

    public function edit(int $id)
    {
        // recuperer le panier, soit plein, soit nouveau panier vide
        $panier = $this->session->get('panier', []);

        // si j'ai deja un produit avec cet identifiant dans mon panier
        if (!empty($panier[$id])) {
            $panier[$id]--;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        // recuperer le panier, soit plein, soit nouveau panier vide
        $panier = $this->session->get('panier', []);

        // si j'ai deja un produit avec cet identifiant dans mon panier
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array
    {
        // recuperer chaque produits ajouté au panier
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity,
            ];
        }
        return $panierWithData;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item){
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}
