<?php

namespace XProjects\Articlenav\Controller;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ArticleModel;
use Contao\Controller;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticlenavController extends AbstractFrontendModuleController {

  protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response {
    global $objPage;
    $pageID = $objPage->id;
    if ($this->xarticlenavpageid != 0) {
      $pageID = $this->xarticlenavpageid;
    }
    $assetsDir = 'bundles/articlenav';
    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir . '/js/articlenav.js|static';
    $articleItems = array();
    $objArticles = ArticleModel::findPublishedByPidAndColumn($pageID, 'main');
    if ($objArticles !== null) {
      foreach ($objArticles as $objRow) {
        if ($objRow->xarticlenav == 0) {
          array_push($articleItems, [
              'hrefalias' => Controller::replaceInsertTags('{{link_url::' . $pageID . '}}') . '#' . $objRow->alias,
              'href' => Controller::replaceInsertTags('{{link_url::' . $pageID . '}}') . '#article-' . $objRow->id,
              'base' => Controller::replaceInsertTags('{{link_url::' . $pageID . '}}'),
              'title' => $objRow->title,
              'text' => $objRow->title,
              'data-id' => 'article-' . $objRow->id,
              'data-alias' => $objRow->alias,
              'id' => $objRow->id,
          ]);
        }
      }
    }
    $template->items = $articleItems;
    return $template->getResponse();
  }

}
