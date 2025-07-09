import {Controller} from '@hotwired/stimulus';

export default class ArticleNavController extends Controller {

    static values = {
        href: {
            type: String, default: ''
        }, ident: {
            type: String, default: ''
        }, alias: {
            type: Number, default: 0
        }
    }

    navigate() {

        const href = this.hrefValue;
        const ident = this.identValue;
        const alias = this.aliasValue;

        console.log(href);
        console.log(ident);
        console.log(alias);

    }

}