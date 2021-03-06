<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsError;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\GenericPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use GenericPage;
}