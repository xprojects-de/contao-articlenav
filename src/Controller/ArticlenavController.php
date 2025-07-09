<?php

namespace XProjects\Articlenav\Controller;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ArticleModel;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ArticlenavController extends AbstractFrontendModuleController
{
    protected Packages $packages;
    private ContentUrlGenerator $contentUrlGenerator;

    public function __construct(
        Packages            $packages,
        ContentUrlGenerator $contentUrlGenerator
    )
    {
        $this->packages = $packages;
        $this->contentUrlGenerator = $contentUrlGenerator;
    }

    public function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        try {

            $GLOBALS['TL_JAVASCRIPT'][] = $this->packages->getUrl('articlenav.js', 'articlenav');

            $cssID = StringUtil::deserialize($model->cssID, true);
            $styleId = (string)($cssID[0] ?? '');
            $styleClass = (string)($cssID[1] ?? '');

            $pageModel = $this->getPageModel();

            if ((int)$model->articlenavpageid !== 0) {

                $pageModel = PageModel::findById($model->articlenavpageid);
                if (!$pageModel instanceof PageModel) {
                    throw new PageNotFoundException('Not found');
                }

            }

            $url = $this->contentUrlGenerator->generate($pageModel, [], UrlGeneratorInterface::ABSOLUTE_URL);

            $articleItems = [];

            $objArticles = ArticleModel::findPublishedByPidAndColumn($pageModel->id, 'main');
            if ($objArticles !== null) {

                foreach ($objArticles as $objRow) {

                    if ((int)$objRow->xarticlenav === 0) {

                        $articleItems[] = [
                            'hrefalias' => $url . '#' . $objRow->alias,
                            'href' => $url . '#article-' . $objRow->id,
                            'base' => $url,
                            'title' => $objRow->title,
                            'text' => $objRow->title,
                            'data-id' => 'article-' . $objRow->id,
                            'data-alias' => $objRow->alias,
                            'id' => $objRow->id,
                        ];

                    }

                }

            }

            $template->set('id', $model->id);
            $template->set('containerId', \trim($styleId) !== '' ? \trim($styleId) : 'articlenavcontainer_' . $model->id);
            $template->set('class', \trim($styleClass) !== '' ? \trim($styleClass) : 'articlenav ');
            $template->set('items', $articleItems);

            return $template->getResponse();

        } catch (\Throwable) {
        }

        throw new PageNotFoundException('Not found');

    }

}
