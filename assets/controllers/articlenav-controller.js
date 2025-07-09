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

        console.log('drinnen');

        console.log(this.hrefValue);
        console.log(this.identValue);
        console.log(this.aliasValue);

    }

}