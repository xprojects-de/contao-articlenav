<?php

declare(strict_types=1);

namespace XProjects\Articlenav\Controller;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ArticleModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsFrontendModule(self::TYPE, category: 'miscellaneous', template: 'frontend_module/onepagearticlenav')]
class ArticlenavController extends AbstractFrontendModuleController
{
    public const TYPE = 'onepagearticlenav';

    private ContentUrlGenerator $contentUrlGenerator;

    public function __construct(
        ContentUrlGenerator $contentUrlGenerator
    )
    {
        $this->contentUrlGenerator = $contentUrlGenerator;
    }

    /**
     * @param FragmentTemplate $template
     * @param ModuleModel $model
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $cssID = StringUtil::deserialize($model->cssID, true);
        $styleId = (string)($cssID[0] ?? '');
        $styleClass = (string)($cssID[1] ?? '');

        $preventEvent = true;

        $pageModel = $this->getPageModel();
        if (!$pageModel instanceof PageModel) {
            throw new PageNotFoundException('not page model given');
        }

        if ((int)$model->articlenavpageid !== 0) {

            $customPageModel = PageModel::findById($model->articlenavpageid);
            if ($customPageModel instanceof PageModel) {

                $preventEvent = $customPageModel->id === $pageModel->id;
                $pageModel = $customPageModel;

            }

        }

        $url = $this->contentUrlGenerator->generate($pageModel, [], UrlGeneratorInterface::ABSOLUTE_URL);

        $offsetTop = 0;
        if ((int)$model->articlenavoffsettop > 0) {
            $offsetTop = (int)$model->articlenavoffsettop;
        }

        $articleItems = [];

        $objArticles = ArticleModel::findPublishedByPidAndColumn($pageModel->id, 'main');
        if ($objArticles !== null) {

            foreach ($objArticles as $objRow) {

                if ((int)$objRow->articlenav === 0) {

                    $articleItems[] = [
                        'hrefalias' => $url . '#' . $objRow->alias,
                        'href' => $url . '#article-' . $objRow->id,
                        'base' => $url,
                        'title' => $objRow->title,
                        'text' => $objRow->title,
                        'articleid' => 'article-' . $objRow->id,
                        'alias' => $objRow->alias,
                        'id' => $objRow->id
                    ];

                }

            }

        }

        $template->set('id', $model->id);
        $template->set('containerId', \trim($styleId) !== '' ? \trim($styleId) : 'articlenavcontainer_' . $model->id);
        $template->set('class', \trim($styleClass) !== '' ? \trim($styleClass) : 'articlenav ');
        $template->set('items', $articleItems);
        $template->set('offsetTop', $offsetTop);
        $template->set('preventEvent', $preventEvent === true ? 1 : 0);

        return $template->getResponse();

    }

}
