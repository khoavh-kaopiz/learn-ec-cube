<?php

namespace Customize\Controller;

use Eccube\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductBoardController extends AbstractController
{
    /**
     * @Route("/product-board", name="product_board", methods={"GET"})
     */
    public function index(Request $request, ProductRepository $productRepository)
    {
        $qb = $productRepository->createQueryBuilder('p')
            ->andWhere('p.Status = 1')
            ->orderBy('p.create_date', 'DESC');

        $page = max(1, (int)$request->query->get('page', 1));
        $limit = 20;
        $qb->setFirstResult(($page - 1) * $limit)->setMaxResults($limit);

        $products = $qb->getQuery()->getResult();

        return $this->render('ProductBoard/index.twig', [
            'products' => $products,
            'page' => $page,
            'limit' => $limit,
        ]);
    }
}
