<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Item;
use AppBundle\Entity\Repository\ItemRepository;
use AppBundle\Form\Type\ItemType;

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
 * Class ItemController
 * @package AppBundle\Controller\Api
 *
 * @RouteResource("item")
 */
class ItemController extends AbstractController
{

    /**
     * Returns a single Item
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Item",
     *     statusCodes={
     *         200="Returned when the item is existing",
     *         404="Returned when the item has not been found"
     *     }
     * )
     *
     * @param int $id Unique identifier of an item
     *
     * @return Item
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        return $this->findEntityByIdentifierCode($id);
    } 

    /**
     * Creates a new Item
     *
     * @ApiDoc(
     *     input="AppBundle\Entity\Item",
     *     output="AppBundle\Entity\Item",
     *     statusCodes={
     *         200="Returned when the Item has been created",
     *         400="Returned when the Item has a violation",     
     *         400="Returned when the Item has a violation"
     *     }
     * )
     *
     * @param Request $request
     *
     * @return Item
     * @throws BadRequestHttpException
     */
    public function postAction(Request $request)
    {
        return $this->createEntity($request);
    }    

    /**
     * Updates an existing Item
     *
     * @ApiDoc(
     *     input="AppBundle\Entity\Item",
     *     output="AppBundle\Entity\Item",
     *     statusCodes={
     *         200="Returned when the Item has been updated",
     *         400="Returned when the Item has a violation",
     *         404="Returned when the Item has not been found"
     *     }
     * )
     *
     * @param Request $request
     * @param int     $id Unique identifier of an item
     *
     * @return object
     */
    public function putAction(Request $request, $id)
    {
        return $this->updateEntity($request, $id);
    }

    /**
     * Deletes an existing Item
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Item",
     *     statusCodes={
     *         200="Returned when the Item has been deleted",
     *         403="Returned when the Item is not authorized",
     *         404="Returned when the Item has not been found"
     *     }
     * )
     *
     * @param int $id Unique identifier of an item
     *
     * @return object
     */
    public function deleteAction($id)
    {
        return $this->deleteEntity($id);
    }

    /**
     * Returns a collection of Items
     *
     * @ApiDoc(
     *     output="array<AppBundle\Entity\Item>",
     *     statusCodes={
     *         200="Returned when no usage mistake occurs",
     *         403="Returned when the Item is not authorized"
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
        return Item::class;
    }            
}
