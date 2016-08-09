<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Order;
use AppBundle\Entity\Repository\OrderRepository;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class OrderController
 * @package AppBundle\Controller\Api
 *
 * @RouteResource("order")
 */
class OrderController extends AbstractController
{

    /**
     * Returns a single Order
     *
     * @ApiDoc(
     *     description="Returns a single Order",
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         404="Returned when the order has not been found"
     *     }
     * )
     *
     * @param int $id Unique identifier of an order
     *
     * @return Order
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        return $this->findEntityByIdentifier($id);
    }    

    /**
     * @ApiDoc(
     *     description="Creates a new Order",     
     *     input="AppBundle\Entity\Order",
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200="Returned when the Order has been created",   
     *         400="Returned when the Order has a violation"
     *     }
     * )
     *
     * @param Request $request
     *
     * @return Order
     * @throws BadRequestHttpException
     */
    public function postAction(Request $request)
    {
        return $this->createEntity($request);
    }  

    /**
     * Updates an existing Order
     *
     * @ApiDoc(
     *     input="AppBundle\Entity\Order",
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200="Returned when the Order has been updated",
     *         404="Returned when the Order has not been found"
     *     }
     * )
     *
     * @param Request $request
     * @param int     $id Unique identifier of an order
     *
     * @return object
     */
    public function putAction(Request $request, $id)
    {
        return $this->updateEntity($request, $id);
    }

    /**
     * Deletes an existing Order
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200="Returned when the Order has been deleted",
     *         404="Returned when the Order has not been found"
     *     }
     * )
     *
     * @param int $id Unique identifier of an order
     *
     * @return object
     */
    public function deleteAction($id)
    {
        return $this->deleteEntity($id);
    }

    /**
     * Returns a collection of Orders
     *
     * @ApiDoc(
     *     output="array<AppBundle\Entity\Order>",
     *     statusCodes={
     *         200="Returned when no usage mistake occurs",
     *     }
     * )
     *
     * @QueryParam(name="filter", array=true, nullable=true, description="Filter for user listing.")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset from which to start listing entities.")
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Maximum number of entities in the result set.")
     * @QueryParam(name="sort", array=true, nullable=true, description="Attribute to sort with")
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return array
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $filter = $paramFetcher->get('filter');
        $sort = $paramFetcher->get('sort');
        $limit = intval($paramFetcher->get('limit'));
        $offset = intval($paramFetcher->get('offset'));

        return $this->findEntities($filter, $sort, $limit, $offset);
    }

    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return Order::class;
    }        
}
