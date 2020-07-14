<?php

namespace XProjects\Articlenav\Controller;

use Contao\Module;
use Contao\BackendTemplate;
use Contao\ArticleModel;
use Contao\Controller;

class ArticlenavModuleController extends Module {

  protected $strTemplate = 'nav_xarticlenav';

  public function generate() {
    if (TL_MODE == 'BE') {
      $objTemplate = new BackendTemplate('be_wildcard');
      $objTemplate->wildcard = '### ModuleXArticleNav ###';
      $objTemplate->id = $this->id;
      $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
      return $objTemplate->parse();
    }

    $strBuffer = parent::generate();
    return ($this->Template->items != '') ? $strBuffer : '';
  }

  protected function compile() {
    global $objPage;
    $pageID = $objPage->id;
    if ($this->articlenavpageid != 0) {
      $pageID = $this->articlenavpageid;
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
    $this->Template->items = $articleItems;
  }

}
