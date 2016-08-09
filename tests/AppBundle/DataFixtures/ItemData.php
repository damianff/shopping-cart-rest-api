<?php

namespace Tests\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;

/**
 * Class UserData
 *
 * @package Tests\AppBundle\DataFixtures
 */
class ItemData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @return $this
     */
    public function load(ObjectManager $manager)
    {
        $item = new Item();
        $item
            ->setName('Item 1')
            ->setDescription('description of item 1')
            ->setPrice(10);

        $manager->persist($item);
        $manager->flush();

        $this->addReference('item-1', $item);

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}