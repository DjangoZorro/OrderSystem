<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Invoice;
use App\Entity\ProductInvoice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ShoppingCartController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
      $this->session = $session;
    }

    /**
     * @Route("/shoppingcart", name="shopping_cart")
     */
    public function index()
    {
        $getCart = $this->session->get('cart', []);

        return $this->render('shopping_cart/index.html.twig', [
            'cart' => $getCart,
        ]);
    }

    /**
     * @Route("/added/{id}", name="product_added", methods={"GET", "POST"})
     */
    public function addToCart(Product $product)
    {
      $getCart = $this->session->get('cart', []);

      if(isset($getCart[$product->getId()])) {
        $getCart[$product->getId()]['quantity']++;
      } else {
        $getCart[$product->getId()] = array(
          'quantity' => 1,
          'name' => $product->getName(),
          'price' => $product->getPrice(),
          'id' => $product->getId()
        );
      }

      $this->session->set('cart', $getCart);

      return $this->redirectToRoute('shopping_cart',[
      ]);
    }

    /**
     * @Route("/paidall", name="paidall")
     */
    public function paidAll()
    {
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();

        $cart = $session->get('cart', array());

        $em = $this->getDoctrine()->getManager();

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setUser($this->getUser());

        if (isset($cart)) {
          $em->persist($invoice);
          $em->flush();

          foreach ($cart as $id => $quantity) {
            $product_invoice = new ProductInvoice();
            $product_invoice->setInvoice($invoice);

            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find($id);

            $product_invoice->setQuantity($quantity['quantity']);
            $product_invoice->setProduct($product);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($product_invoice);
            $em->flush();
          }
        }

        $session->clear();

        return $this->redirectToRoute('default');
    }
}
