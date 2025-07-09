import {Application} from '@hotwired/stimulus';
import ArticleNavController from './controllers/articlenav-controller';

const articleNavApplication = Application.start();
articleNavApplication.register('articlenav', ArticleNavController);