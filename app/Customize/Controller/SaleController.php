<?php

namespace Customize\Controller;

use Customize\Entity\Sale;
use Customize\Repository\SaleRepository;
use Eccube\Controller\AbstractController;
use Eccube\Repository\BaseInfoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaleController extends AbstractController
{
    /**
     * @var SaleRepository
     */
    protected $saleRepository;

    /**
     * @var BaseInfoRepository
     */
    protected $baseInfoRepository;

    /**
     * SaleController constructor.
     *
     * @param SaleRepository $saleRepository
     * @param BaseInfoRepository $baseInfoRepository
     */
    public function __construct(
        SaleRepository $saleRepository,
        BaseInfoRepository $baseInfoRepository
    ) {
        $this->saleRepository = $saleRepository;
        $this->baseInfoRepository = $baseInfoRepository;
    }

    /**
     * Sale list page.
     *
     * @Route("/sale", name="sale_list", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        // Get all active sales
        $Sales = $this->saleRepository->findActive();

        return $this->render('Sale/index.twig', [
            'Sales' => $Sales,
            'BaseInfo' => $this->baseInfoRepository->get()
        ]);
    }
}