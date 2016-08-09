<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\LineItem;
use AppBundle\Entity\Order;
use AppBundle\Entity\Repository\LineItemRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ItemController
 * @package AppBundle\Controller\Api
 *
 * @RouteResource("lineItem")
 */
class LineItemController extends AbstractController
{

    /**
     * Creates a new Item from the Order
     *
     * @ApiDoc(
     *     input="AppBundle\Entity\LineItem",
     *     output="AppBundle\Entity\LineItem",
     *     statusCodes={
     *         200="Returned when the lineItem has been created",  
     *         400="Returned when the lineItem has a violation"
     *     }
     * )
     *
     * @param Request $request
     * @param Order $order Order for the new Item     
     *
     * @return LineItem
     * @throws BadRequestHttpException
     */
    public function postAction(Order $order,Request $request)
    {

        $lineItem = $this->deserializePayload($request);

        if (!is_object($lineItem)) {
            throw $this->createBadRequestException("No valid payload found");
        }

        try {
            $manager = $this->getDoctrine()->getManager();

            $order->setTotal($order->getTotal() + ($lineItem->getQuantity() * $lineItem->getPrice()));
            $manager->persist($order);
            $manager->flush($order);

            $lineItem->setOrder($order);            
            $manager->persist($lineItem);
            $manager->flush($lineItem);
            $manager->refresh($lineItem);

            return new JSonResponse(
                  array('code' => 200,
                        'data' => $lineItem)
            );
        } catch (ConstraintViolationException $exception) {
            throw $this->createBadRequestException('Constraint violation occured', $exception);
        }

        throw $this->createBadRequestException('An unknown error occured while persisting this entity', $exception);             
    }    

    /**
     * Deletes an existing Item from the Order
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\LineItem",
     *     statusCodes={
     *         200="Returned when the Item from the Order has been deleted",
     *         404="Returned when the Item from the Order has not been found"
     *     }
     * )
     *
     * @param int $id Unique identifier of an Item from the Order
     *
     * @return object
     */
    public function deleteAction($id)
    {
        return $this->deleteEntity($id);
    } 

    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return LineItem::class;
    }            
}
