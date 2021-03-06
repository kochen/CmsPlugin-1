<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;
    
    /**
     * @var FactoryInterface
     */
    private $pageFactory;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $pageFactory
     * @param PageRepositoryInterface $pageRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $pageFactory,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given there are :number pages
     */
    public function thereArePages($number)
    {
        $number = (int)$number;

        for ($i = 0; $i < $number; $i++) {
            $this->createPage();
        }
    }

    /**
     * @Given there is a cms page with :name name
     */
    public function thereIsACmsPageWithName($name)
    {
        $this->createPage();
        /** @var PageInterface $page */
        $page = $this->sharedStorage->get('page');
        $page->setName($name);
        $page->setCode(strtolower(str_replace(' ', '_', $name)));

        $this->entityManager->flush();
    }

    /**
     * @Given it has :metaKeywords meta keywords
     */
    public function itHasMetaKeywords($metaKeywords)
    {
        $this->createPage();
        /** @var PageInterface $page */
        $page = $this->sharedStorage->get('page');
        $page->setMetaKeywords($metaKeywords);

        $this->entityManager->flush();
    }

    /**
     * @Given it has :metaDescription meta description
     */
    public function itHas($metaDescription)
    {
        $this->createPage();
        /** @var PageInterface $page */
        $page = $this->sharedStorage->get('page');
        $page->setMetaDescription($metaDescription);

        $this->entityManager->flush();
    }

    /**
     * @Given it has :content content
     */
    public function itHasContent($content)
    {
        $this->createPage();
        /** @var PageInterface $page */
        $page = $this->sharedStorage->get('page');
        $page->setMetaKeywords($content);

        $this->entityManager->flush();
    }

    private function createPage()
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();
        $page->setCode($this->randomStringGenerator->generate());
        $channel = $this->sharedStorage->get('channel');
        $page->setCurrentLocale($channel->getLocales()->first()->getCode());
        $page->setName($this->randomStringGenerator->generate());
        $page->setSlug($this->randomStringGenerator->generate());
        $page->setContent($this->randomStringGenerator->generate());

        $this->pageRepository->add($page);
        $this->sharedStorage->set('page', $page);
    }
}
