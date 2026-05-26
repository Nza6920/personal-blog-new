function copyText(value) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(value);
    }

    return new Promise((resolve, reject) => {
        const textarea = document.createElement('textarea');
        textarea.value = value;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            if (!document.execCommand('copy')) {
                throw new Error('Copy command was rejected.');
            }

            resolve();
        } catch (error) {
            reject(error);
        } finally {
            document.body.removeChild(textarea);
        }
    });
}

export function initTopicCopyButtons() {
    if (window.__topicCopyHandlerBound) {
        return;
    }

    window.__topicCopyHandlerBound = true;

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-copy-button]');

        if (!button) {
            return;
        }

        const topicBody = document.querySelector('.topic-body');
        const pre = button.closest('pre');

        if (!topicBody || !pre) {
            return;
        }

        const icon = button.querySelector('i');
        const code = pre.querySelector('code');
        const copyLabel = topicBody.dataset.copyLabel || '';
        const copiedLabel = topicBody.dataset.copiedLabel || '';
        const copyAriaLabel = topicBody.dataset.copyAriaLabel || '';
        const codeText = code ? code.textContent : pre.textContent;
        const resetTimer = button.dataset.copyResetTimer
            ? Number(button.dataset.copyResetTimer)
            : null;

        copyText(codeText || '').then(() => {
            if (resetTimer) {
                window.clearTimeout(resetTimer);
            }

            button.classList.add('is-copied');
            button.setAttribute('aria-label', copiedLabel);
            button.setAttribute('title', copiedLabel);

            if (icon) {
                icon.className = 'icon-check';
            }

            const nextResetTimer = window.setTimeout(() => {
                button.classList.remove('is-copied');
                button.setAttribute('aria-label', copyAriaLabel);
                button.setAttribute('title', copyLabel);
                button.dataset.copyResetTimer = '';

                if (icon) {
                    icon.className = 'icon-clipboard';
                }
            }, 1500);

            button.dataset.copyResetTimer = String(nextResetTimer);
        }).catch(() => {
            button.setAttribute('aria-label', copyAriaLabel);
            button.setAttribute('title', copyLabel);

            if (icon) {
                icon.className = 'icon-clipboard';
            }
        });
    });
}
