class VanillaCookieConsent {
    config;

    constructor(config) {
        this.config = config;
    }

    acceptAll() {
        return this.request(this.config['accept-all'])
            .then((data) => this.addScripts(data));
    }

    acceptEssentials() {
        return this.request(this.config['accept-essentials'])
            .then((data) => this.addScripts(data));
    }

    configure(data) {
        return this.request(this.config['accept-configuration'], data)
            .then((data) => this.addScripts(data));
    }

    reset() {
        return this.request(this.config['reset'])
            .then((data) => this.addNotice(data));
    }

    request(url, data = null) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: data,
        }).then((response) => response.json());
    }

    addScripts(data) {
        if (!data.scripts) {
            return;
        }

        data.scripts.forEach(script => {
            const scriptRegex = /<script[^]*<\/script>/;
            if (!scriptRegex.test(script)) {
                console.error('Invalid script tag: ' + script);
            }
            let tmp = document.createElement('div');
            tmp.innerHTML = script;

            let tag = document.createElement('script');
            tag.textContent = tmp.querySelector('script').textContent;
            for (const attr of tmp.querySelector('script').attributes) {
                tag.setAttribute(attr.name, attr.value);
            }
            tag.setAttribute('data-cookie-consent', true);

            document.head.appendChild(tag);
        });
    }

    addNotice(data) {
        if (!data.notice) {
            return;
        }

        let tmp = document.createElement('div');
        tmp.innerHTML = data.notice;

        let cookies = tmp.querySelector('#cookies-policy')
        document.body.appendChild(cookies);

        let tags = tmp.querySelectorAll('[data-cookie-consent]');

        if (!tags.length) {
            return;
        }

        tags.forEach(tag => {
            if (tag.nodeName === 'SCRIPT') {
                const script = document.createElement('script');
                script.textContent = tag.textContent;
                document.body.appendChild(script);
            } else {
                document.body.appendChild(tag);
            }
        });
    }
}

window.addEventListener('DOMContentLoaded', () => {
    window.VanillaCookieConsent = new VanillaCookieConsent(php_config);
});