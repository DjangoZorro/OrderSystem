<?php

namespace App\Controller;

use App\Entity\ProductInvoice;
use App\Form\ProductInvoiceType;
use App\Repository\ProductInvoiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productinvoice")
 */
class ProductInvoiceController extends AbstractController
{
    /**
     * @Route("/", name="product_invoice_index", methods={"GET"})
     */
    public function index(ProductInvoiceRepository $productInvoiceRepository): Response
    {
        return $this->render('product_invoice/index.html.twig', [
            'product_invoices' => $productInvoiceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_invoice_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productInvoice = new ProductInvoice();
        $form = $this->createForm(ProductInvoiceType::class, $productInvoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productInvoice);
            $entityManager->flush();

            return $this->redirectToRoute('product_invoice_index');
        }

        return $this->render('product_invoice/new.html.twig', [
            'product_invoice' => $productInvoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_invoice_show", methods={"GET"})
     */
    public function show(ProductInvoice $productInvoice): Response
    {
        return $this->render('product_invoice/show.html.twig', [
            'product_invoice' => $productInvoice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_invoice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductInvoice $productInvoice): Response
    {
        $form = $this->createForm(ProductInvoiceType::class, $productInvoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_invoice_index');
        }

        return $this->render('product_invoice/edit.html.twig', [
            'product_invoice' => $productInvoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_invoice_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductInvoice $productInvoice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productInvoice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productInvoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_invoice_index');
    }
}
