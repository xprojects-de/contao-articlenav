<?php

declare(strict_types=1);

namespace XProjects\Articlenav\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use XProjects\Articlenav\ArticlenavBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [BundleConfig::create(ArticlenavBundle::class)->setLoadAfter([ContaoCoreBundle::class])];
    }
}
