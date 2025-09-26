<?php

namespace Customize\Controller\Admin\Sale;

use Customize\Entity\Sale;
use Customize\Form\Type\SaleType;
use Customize\Repository\SaleRepository;
use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/%eccube_admin_route%/sale")
 */
class SaleController extends AbstractController
{
    /**
     * @var SaleRepository
     */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * @Route("", name="admin_sale")
     * @Template("@admin/Sale/index.twig")
     */
    public function index()
    {
        $Sales = $this->entityManager->getRepository(Sale::class)->findBy([], ['id' => 'DESC']);

        return [
            'Sales' => $Sales,
        ];
    }

    /**
     * @Route("/new", name="admin_sale_new")
     * @Template("@admin/Sale/new.twig")
     */
    public function create(Request $request)
    {
        $Sale = new Sale();
        $builder = $this->formFactory->createBuilder(SaleType::class, $Sale);
        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($Sale);
            $this->entityManager->flush();

            $this->addSuccess('admin.common.create.complete', 'admin');

            return $this->redirectToRoute('admin_sale');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}/edit", name="admin_sale_edit", requirements={"id" = "\d+"})
     * @Template("@admin/Sale/edit.twig")
     */
    public function edit(Request $request, $id)
    {
        $Sale = $this->entityManager->find(Sale::class, $id);
        if (!$Sale) {
            throw new NotFoundHttpException('Sale not found');
        }

        $builder = $this->formFactory->createBuilder(SaleType::class, $Sale);
        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($Sale);
            $this->entityManager->flush();

            $this->addSuccess('admin.common.save.complete', 'admin');

            return $this->redirectToRoute('admin_sale');
        }

        return [
            'form' => $form->createView(),
            'Sale' => $Sale,
        ];
    }

    /**
     * @Route("/{id}/delete", name="admin_sale_delete", methods={"GET"}, requirements={"id" = "\d+"})
     * @Template("@admin/Sale/delete.twig")
     */
    public function delete(Request $request, $id)
    {
        $Sale = $this->entityManager->find(Sale::class, $id);
        if (!$Sale) {
            throw new NotFoundHttpException('Sale not found');
        }

        $form = $this->formFactory->createBuilder(FormType::class)
            ->getForm();

        return [
            'Sale' => $Sale,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}/delete", name="admin_sale_delete_confirm", methods={"POST"}, requirements={"id" = "\d+"})
     */
    public function deleteConfirm(Request $request, $id)
    {
        $Sale = $this->entityManager->find(Sale::class, $id);
        if (!$Sale) {
            throw new NotFoundHttpException('Sale not found');
        }

        $form = $this->formFactory->createBuilder(FormType::class)
            ->getForm();
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->remove($Sale);
                $this->entityManager->flush();

                $this->addSuccess('admin.common.delete.complete', 'admin');
            } catch (\Exception $e) {
                $this->addError('admin.common.delete.error', 'admin');
            }

            return $this->redirectToRoute('admin_sale');
        }

        return $this->redirectToRoute('admin_sale');
    }
}
