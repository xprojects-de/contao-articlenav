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

    static targets = ['navitem']

    navigate(event) {

        event.preventDefault();

        const elements = document.querySelectorAll('a[data-controller]');

        elements.forEach(element => {
            element.classList.remove('active');
        });

        this.navitemTarget.classList.add('active');

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