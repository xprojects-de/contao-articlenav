import {Controller} from '@hotwired/stimulus';

export default class ArticleNavController extends Controller {

    static values = {
        imageurl: {
            type: String, default: ''
        },
        closeimageurl: {
            type: String, default: ''
        },
        completesize: {
            type: Number, default: 0
        }
    }

    static targets = ['menucontainer', 'buttoncontainer', 'openicon', 'closeicon']

    connect() {
        super.connect()
        this.init();
    }

    open() {

        if (this.completesizeValue === 1) {
            document.body.classList.add('mobileMenuOverflowHidden');
        }

        if (this.menucontainerTarget.style.display !== 'block') {

            this.buttoncontainerTarget.classList.add('xmobilemenuactive');
            this.menucontainerTarget.style.width = window.innerWidth + "px";
            this.menucontainerTarget.style.opacity = 0;
            this.menucontainerTarget.style.display = 'block'; // Falls das Element vorher `display: none` war
            this.menucontainerTarget.style.transition = 'opacity 0.2s ease-in-out';

            setTimeout(() => {
                this.menucontainerTarget.style.opacity = 1;
            }, 10);

            if (this.closeimageurlValue !== '' && this.completesizeValue === 0) {
                this.openiconTarget.src = this.closeimageurlValue;
            }

        } else {

            this.buttoncontainerTarget.classList.remove('xmobilemenuactive');
            this.menucontainerTarget.style.opacity = 0;
            this.menucontainerTarget.style.display = 'none';

            if (this.imageurlValue !== '' && this.completesizeValue === 0) {
                this.openiconTarget.src = this.imageurlValue;
            }

        }

    }

    close() {

        if (this.completesizeValue === 1) {
            document.body.classList.remove('mobileMenuOverflowHidden');
        }

        this.menucontainerTarget.style.opacity = 0;
        this.menucontainerTarget.style.display = 'none';

    }

    init() {

        this.setModeSettings();
        this.setPosition();
        this.setLinksActivation();

    }

    resizeWindow() {
        this.setPosition();
    }

    setModeSettings() {

        this.menucontainerTarget.style.width = '100%';
        this.menucontainerTarget.style.overflow = 'auto';
        this.menucontainerTarget.style.zIndex = 99999;
        this.menucontainerTarget.style.margin = '0';

        if (this.completesizeValue === 0) {
            this.menucontainerTarget.style.marginTop = '10px';
        }

        this.menucontainerTarget.style.left = '0';
        this.menucontainerTarget.style.top = '0';
        this.menucontainerTarget.style.position = 'absolute';

    }

    getPosition(element) {

        const rect = element.getBoundingClientRect();
        const parent = element.offsetParent;

        if (parent) {

            const parentRect = parent.getBoundingClientRect();

            return {
                top: rect.top - parentRect.top,
                left: rect.left - parentRect.left
            };

        }

        return {
            top: rect.top,
            left: rect.left
        };

    }


    setPosition() {

        if (this.completesizeValue === 1) {
            this.menucontainerTarget.style.height = window.innerHeight + 'px';
        } else {

            const topValue = (this.getPosition(this.buttoncontainerTarget).top + this.buttoncontainerTarget.offsetHeight);
            const maxHeight = window.innerHeight - (this.getPosition(this.buttoncontainerTarget).top + this.buttoncontainerTarget.offsetHeight);

            this.menucontainerTarget.style.top = topValue + 'px';
            this.menucontainerTarget.style.maxHeight = maxHeight + 'px';
            this.menucontainerTarget.style.width = '100%';

        }

    }

    setLinksActivation() {

        const self = this;

        this.menucontainerTarget.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {

                self.close();

                if (self.imageurlValue !== '' && self.completesizeValue === 0) {
                    self.openiconTarget.src = self.imageurlValue;
                }

            });

        });

    }

}