import {Controller} from '@hotwired/stimulus';

export default class ArticleNavController extends Controller {

    static values = {
        href: {
            type: String, default: ''
        },
        ident: {
            type: String, default: ''
        },
        alias: {
            type: String, default: ''
        },
        offset: {
            type: Number, default: 0
        }
    }

    navigate(event) {

        // event.preventDefault();
        if (this.offsetValue <= 0) {
            this.scrollToElement(this.identValue);
        } else {
            this.scrollToElementWithOffset(this.identValue, this.offsetValue);
        }

    }

    scrollToElement(targetID) {
        const element = document.getElementById(targetID);
        if (element) {

            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    }

    scrollToElementWithOffset(targetID, offset) {
        const element = document.getElementById(targetID);
        if (element) {

            const elementPosition = element.offsetTop;
            const targetPosition = elementPosition - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });

        }
    }

}