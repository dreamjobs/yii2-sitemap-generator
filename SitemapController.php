<?php

namespace dreamjobs\sitemap;

use Yii;

use yii\console\Controller;

/**
 * Class SitemapController
 * @package dreamjobs\sitemap
 *
 * @property SitemapBuilder $builder
 */
class SitemapController extends Controller
{
    /** @var string Alias to directory contains sitemap-models */
    public $modelsPath = '@console/models/sitemap';
    /** @var string Namespace of sitemap-models files */
    public $modelsNamespace = 'console\models\sitemap';
    /** @var string Path to saving sitemap-files. As webroot: "http://example.com" */
    public $savePathAlias = '@frontend/web';
    /** @var string Name of sitemap-file, saved to webroot: "http://example.com/sitemap.xml" */
    public $sitemapFileName = 'sitemap.xml';
    /** @var array Default config for sitemap builder */
    public $builderConfig = [
        'urlsPerFile' => 10000,
    ];
    /** @var string Base Url for sitemap links. As webroot: "http://example.com" */
    public $baseUrl = null;

    /**
     * @inheritdoc
     */
    public function getHelpSummary()
    {
        return 'Console command for generate sitemap files for Models specified in console config';
    }

    /**
     * Index action for run sitemap creation
     */
    public function actionIndex()
    {
        $dataHandler = new SitemapDataHandler($this->savePathAlias, $this->sitemapFileName, $this->baseUrl, [
            'builderConfig' => $this->builderConfig,
        ]);

        $models = $dataHandler->getModelsClasses($this->modelsPath, $this->modelsNamespace);
        $dataHandler->handleModels($models);
    }
}
