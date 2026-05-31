document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toast]').forEach((toast) => {
        const redirect = toast.dataset.redirect;

        if (redirect) {
            setTimeout(() => {
                window.location.href = redirect;
            }, 2000);
        }

        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-2');

            setTimeout(() => toast.remove(), 300);
        }, redirect ? 2000 : 5000);
    });

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const field = button.closest('[data-password-field]');
            const input = field?.querySelector('input[type="password"], input[type="text"]');
            const showIcon = field?.querySelector('[data-icon-show]');
            const hideIcon = field?.querySelector('[data-icon-hide]');

            if (!input) {
                return;
            }

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.setAttribute('aria-label', isHidden ? 'Ocultar senha' : 'Mostrar senha');
            showIcon?.classList.toggle('hidden', isHidden);
            hideIcon?.classList.toggle('hidden', !isHidden);
        });
    });

    const openDialog = (dialog) => {
        dialog.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeDialog = (dialog) => {
        dialog.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    document.querySelectorAll('[data-dialog-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const dialog = document.getElementById(trigger.dataset.dialogOpen);

            if (dialog) {
                openDialog(dialog);
            }
        });
    });

    document.querySelectorAll('[data-dialog]').forEach((dialog) => {
        dialog.querySelectorAll('[data-dialog-close], [data-dialog-backdrop], [data-dialog-wrapper]').forEach((element) => {
            element.addEventListener('click', () => closeDialog(dialog));
        });

        dialog.querySelector('[data-dialog-panel]')?.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        document.querySelectorAll('[data-dialog]:not(.hidden)').forEach((dialog) => {
            closeDialog(dialog);
        });
    });
});
