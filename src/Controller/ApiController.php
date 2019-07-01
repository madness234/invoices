<?php

namespace App\Controller;

use App\Entity\Buyer;
use App\Entity\Invoice;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractFOSRestController
{
    
    /**
     * @Get("/api/buyers.{_format}", defaults={"_format"="json"})
     * @View()
     */
    public function getBuyersAction(Request $request)
    {
        $searchQuery = $request->get('q', null);

        if(!$searchQuery) {
            $view = $this->view(['error' => 'No search query provided'], 422);
            
            return $this->handleView($view);
        }

        $entityManager = $this->getDoctrine()->getManager();
        
        $buyers = $entityManager->getRepository(Buyer::class)->getBuyers($searchQuery, 25);
        
        $view = $this->view($buyers, 200);

        return $this->handleView($view);
    }
    
    /**
     * @Get("/api/invoice-number.{_format}/{year}/{month}", defaults={"_format"="json"})
     * @View()
     */
    public function getInvoiceNumberAction(int $year, int $month)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->getFilters()->disable('softdeleteable');
        
        $count = $entityManager->getRepository(Invoice::class)->getInvoiceCount($year, $month);
        
        $number = $year . '/' . $month . '/' . ($count + 1);
        
        $view = $this->view(['number' => $number], 200);

        return $this->handleView($view);
    }    
}
