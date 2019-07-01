<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class InvoicesController extends Controller
{

    /**
     * @Route("/{page}", name="invoice_list", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, int $page)
    {
        $em = $this->getDoctrine()->getManager();

        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $invoices      = $em->getRepository(Invoice::class)->getInvoices($offset, $limit);
        $invoicesCount = $em->getRepository(Invoice::class)->countInvoices();
        $maxPage       = ceil($invoicesCount / $limit);

        return $this->render('invoices/list.html.twig',
                [
                'invoices' => $invoices,
                'page' => $page,
                'maxPage' => $maxPage
        ]);
    }

    /**
     * @Route("/dodaj", name="invoice_add")
     */
    public function addAction(Request $request)
    {
        $invoice = new Invoice();

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($invoice);
                $entityManager->flush();

                return $this->redirectToRoute('invoice_list');
            }
        }

        return $this->render('invoices/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edycja/{id}", name="invoice_edit")
     */
    public function editAction(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $invoice = $entityManager->getRepository(Invoice::class)->find($id);
        if (!$invoice) {
            return $this->createNotFoundException();
        }

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->persist($invoice);
                $entityManager->flush();
            }
        }

        return $this->render('invoices/add.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/usun/{id}", name="invoice_delete")
     */
    public function deleteAction(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $invoice = $entityManager->getRepository(Invoice::class)->find($id);
        if (!$invoice) {
            return $this->createNotFoundException();
        }

        $entityManager->remove($invoice);
        $entityManager->flush();

        return $this->redirectToRoute('invoice_list');
    }

}