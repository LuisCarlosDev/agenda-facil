document.addEventListener('DOMContentLoaded', () => {
    const servicesOptionsUrl = document.querySelector('meta[name="services-options-url"]')?.content;

    const showToast = (message, type = 'success') => {
        const styles = {
            success: 'border-emerald-200 bg-emerald-50 text-emerald-800',
            error: 'border-red-200 bg-red-50 text-red-800',
        };

        const toast = document.createElement('div');
        toast.dataset.toast = '';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.className = `pointer-events-none fixed top-6 left-1/2 z-50 max-w-md -translate-x-1/2 rounded-lg border px-4 py-3 text-sm shadow-lg transition-all duration-300 ${styles[type] ?? styles.success}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    };

    const populateAppointmentServiceSelect = (select, services, selectedId = null) => {
        const valueToKeep = selectedId ?? select.value;

        select.replaceChildren();

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Selecione um serviço';
        select.appendChild(placeholder);

        services.forEach(({ id, name }) => {
            const option = document.createElement('option');
            option.value = String(id);
            option.textContent = name;
            select.appendChild(option);
        });

        if (valueToKeep && [...select.options].some((option) => option.value === String(valueToKeep))) {
            select.value = String(valueToKeep);
        }
    };

    const fetchAppointmentServices = async () => {
        if (!servicesOptionsUrl) {
            return [];
        }

        const response = await fetch(servicesOptionsUrl, {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            return [];
        }

        const data = await response.json();

        return data.services ?? [];
    };

    const refreshAppointmentServiceSelects = async (selectedId = null) => {
        const selects = document.querySelectorAll('[data-appointment-service-select]');

        if (!selects.length) {
            return;
        }

        const services = await fetchAppointmentServices();

        selects.forEach((select) => {
            populateAppointmentServiceSelect(select, services, selectedId);
        });
    };

    const appendServiceToList = (service) => {
        const panel = document.querySelector('[data-services-panel]');

        if (!panel) {
            return;
        }

        panel.querySelector('[data-services-empty]')?.remove();

        let list = panel.querySelector('[data-services-list]');

        if (!list) {
            list = document.createElement('ul');
            list.dataset.servicesList = '';
            list.className = 'flex flex-col gap-3';
            panel.appendChild(list);
        }

        const item = document.createElement('li');
        item.className = 'flex flex-col gap-3 rounded-lg border border-border px-4 py-4 sm:flex-row sm:items-center sm:justify-between';
        item.dataset.serviceId = String(service.id);

        const content = document.createElement('div');
        content.className = 'min-w-0 flex-1';

        const name = document.createElement('p');
        name.className = 'font-semibold text-heading';
        name.textContent = service.name;
        content.appendChild(name);

        if (service.description) {
            const description = document.createElement('p');
            description.className = 'mt-1 line-clamp-2 text-sm text-muted';
            description.textContent = service.description;
            content.appendChild(description);
        }

        const meta = document.createElement('div');
        meta.className = 'flex shrink-0 items-center gap-3';

        const duration = document.createElement('span');
        duration.className = 'inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600';
        duration.textContent = service.duration;
        meta.appendChild(duration);

        if (service.price) {
            const price = document.createElement('span');
            price.className = 'text-sm font-semibold text-heading';
            price.textContent = service.price;
            meta.appendChild(price);
        }

        item.append(content, meta);
        list.prepend(item);
    };

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

        if (dialog.id === 'new-appointment') {
            refreshAppointmentServiceSelects();
        }
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

    document.querySelectorAll('[data-dialog-auto-open]').forEach((element) => {
        const dialog = document.getElementById(element.dataset.dialogAutoOpen);

        if (dialog) {
            openDialog(dialog);
        }
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

    document.querySelectorAll('[data-service-form]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = form.querySelector('[type="submit"]');

            if (submitButton) {
                submitButton.disabled = true;
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const message = data.message
                        ?? Object.values(data.errors ?? {}).flat()[0]
                        ?? 'Não foi possível cadastrar o serviço.';

                    showToast(message, 'error');

                    return;
                }

                form.reset();

                const dialog = form.closest('[data-dialog]');

                if (dialog) {
                    closeDialog(dialog);
                }

                appendServiceToList(data.service);
                await refreshAppointmentServiceSelects(data.service.id);
                document.dispatchEvent(new CustomEvent('service:created', { detail: data.service }));
                showToast(data.message ?? 'Serviço cadastrado com sucesso!');
            } catch {
                showToast('Não foi possível cadastrar o serviço.', 'error');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        });
    });

    refreshAppointmentServiceSelects();

    const schedulesPreviewUrl = document.querySelector('meta[name="schedules-preview-url"]')?.content;

    const collectScheduleDays = (container) => {
        const days = [];

        container?.querySelectorAll('[data-schedule-day]').forEach((row, index) => {
            days.push({
                day_of_week: row.dataset.dayOfWeek,
                enabled: row.querySelector('[data-schedule-enabled]')?.checked ? '1' : '',
                start_time: row.querySelector('[data-schedule-start]')?.value ?? '',
                end_time: row.querySelector('[data-schedule-end]')?.value ?? '',
                index,
            });
        });

        return days;
    };

    const syncScheduleDayState = (row) => {
        const enabled = row.querySelector('[data-schedule-enabled]')?.checked;
        const times = row.querySelector('[data-schedule-times]');

        if (!times) {
            return;
        }

        times.querySelectorAll('input').forEach((input) => {
            input.disabled = !enabled;
            input.classList.toggle('opacity-50', !enabled);
        });

        row.classList.toggle('opacity-60', !enabled);
    };

    const renderSchedulePreview = (container, slots, dateLabel) => {
        const preview = container?.closest('form')?.querySelector('[data-schedule-preview-slots]');
        const dateEl = container?.closest('form')?.querySelector('[data-schedule-preview-date]');

        if (dateEl) {
            dateEl.textContent = dateLabel || 'Selecione ao menos um dia útil';
        }

        if (!preview) {
            return;
        }

        preview.replaceChildren();

        if (!slots?.length) {
            const empty = document.createElement('p');
            empty.className = 'text-sm text-muted';
            empty.textContent = 'Nenhum intervalo para exibir.';
            preview.appendChild(empty);

            return;
        }

        const wrap = document.createElement('div');
        wrap.className = 'flex flex-wrap gap-2';

        slots.forEach(({ label }) => {
            const chip = document.createElement('span');
            chip.className = 'inline-flex rounded-lg border border-border bg-brand-50 px-3 py-2 text-sm font-medium text-brand-600';
            chip.textContent = label;
            wrap.appendChild(chip);
        });

        preview.appendChild(wrap);
    };

    let schedulePreviewTimer;

    const requestSchedulePreview = async (form) => {
        if (!schedulesPreviewUrl) {
            return;
        }

        const daysContainer = form.querySelector('[data-schedule-days]');
        const days = collectScheduleDays(daysContainer);
        const body = new FormData();

        body.append('_token', form.querySelector('input[name="_token"]')?.value ?? '');

        days.forEach((day, index) => {
            body.append(`days[${index}][day_of_week]`, day.day_of_week);

            if (day.enabled) {
                body.append(`days[${index}][enabled]`, '1');
            }

            body.append(`days[${index}][start_time]`, day.start_time);
            body.append(`days[${index}][end_time]`, day.end_time);
        });

        try {
            const response = await fetch(schedulesPreviewUrl, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                return;
            }

            renderSchedulePreview(daysContainer, data.slots ?? [], data.date_label);
        } catch {
            /* preview opcional */
        }
    };

    const scheduleForm = document.querySelector('[data-schedule-form]');

    if (scheduleForm) {
        scheduleForm.querySelectorAll('[data-schedule-day]').forEach((row) => {
            syncScheduleDayState(row);

            row.querySelector('[data-schedule-enabled]')?.addEventListener('change', () => {
                syncScheduleDayState(row);
                clearTimeout(schedulePreviewTimer);
                schedulePreviewTimer = setTimeout(() => requestSchedulePreview(scheduleForm), 300);
            });

            row.querySelectorAll('[data-schedule-start], [data-schedule-end]').forEach((input) => {
                input.addEventListener('change', () => {
                    clearTimeout(schedulePreviewTimer);
                    schedulePreviewTimer = setTimeout(() => requestSchedulePreview(scheduleForm), 300);
                });
            });
        });

        requestSchedulePreview(scheduleForm);
    }

    document.querySelectorAll('[data-booking-dialog-form]').forEach((form) => {
        const bookingServicesUrl = document.querySelector('meta[name="booking-services-url"]')?.content;
        let servicesByProfessional = {};

        try {
            const parsedServices = JSON.parse(form.dataset.professionalServices || '{}');
            servicesByProfessional = Array.isArray(parsedServices) ? {} : parsedServices;
        } catch {
            servicesByProfessional = {};
        }

        const professionalSelect = form.querySelector('[data-booking-professional]')
            ?? form.querySelector('[name="professional_id"]');
        const serviceSelect = form.querySelector('[data-booking-service]');
        const servicesEmptyHint = form.querySelector('[data-booking-services-empty]');

        const servicesFromTemplate = (professionalId) => {
            const template = form.querySelector(
                `template[data-booking-services-for="${CSS.escape(String(professionalId))}"]`,
            );

            if (!template) {
                return [];
            }

            return [...template.content.querySelectorAll('option')].map((option) => ({
                id: Number(option.value),
                name: option.dataset.name ?? option.textContent.trim(),
                label: option.textContent.trim(),
            }));
        };

        const servicesForProfessional = (professionalId) => {
            const fromTemplate = servicesFromTemplate(professionalId);

            if (fromTemplate.length > 0) {
                return fromTemplate;
            }

            return servicesByProfessional[professionalId]
                ?? servicesByProfessional[String(professionalId)]
                ?? [];
        };

        const renderServiceOptions = (services, professionalId) => {
            if (!serviceSelect) {
                return;
            }

            serviceSelect.replaceChildren();

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = professionalId ? 'Selecione um serviço' : 'Selecione um profissional';
            serviceSelect.appendChild(placeholder);

            if (!professionalId) {
                serviceSelect.disabled = true;
                servicesEmptyHint?.classList.add('hidden');

                return;
            }

            services.forEach(({ id, name, label }) => {
                const option = document.createElement('option');
                option.value = String(id);
                option.textContent = label ?? name;
                serviceSelect.appendChild(option);
            });

            const hasServices = services.length > 0;
            serviceSelect.disabled = !hasServices;
            servicesEmptyHint?.classList.toggle('hidden', hasServices);
        };

        const fetchServicesForProfessional = async (professionalId) => {
            if (!bookingServicesUrl || !professionalId) {
                return [];
            }

            const url = new URL(bookingServicesUrl, window.location.origin);
            url.searchParams.set('professional_id', professionalId);

            try {
                const response = await fetch(url, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    return [];
                }

                const data = await response.json();

                return Array.isArray(data.services) ? data.services : [];
            } catch {
                return [];
            }
        };

        const populateServices = async (professionalId) => {
            if (!professionalId) {
                renderServiceOptions([], '');

                return;
            }

            const embedded = servicesForProfessional(professionalId);
            renderServiceOptions(embedded, professionalId);

            if (embedded.length > 0 || !bookingServicesUrl) {
                return;
            }

            const fetched = await fetchServicesForProfessional(professionalId);

            if (fetched.length > 0) {
                renderServiceOptions(fetched, professionalId);
            }
        };

        const syncServicesFromProfessional = () => {
            populateServices(professionalSelect?.value ?? '');
        };

        professionalSelect?.addEventListener('change', syncServicesFromProfessional);
        professionalSelect?.addEventListener('input', syncServicesFromProfessional);

        document.querySelectorAll('[data-dialog-open="new-appointment"]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                setTimeout(syncServicesFromProfessional, 0);
            });
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = form.querySelector('[type="submit"]');

            if (submitButton) {
                submitButton.disabled = true;
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const message = data.message
                        ?? Object.values(data.errors ?? {}).flat()[0]
                        ?? 'Não foi possível agendar.';

                    showToast(message, 'error');

                    return;
                }

                form.reset();
                populateServices('');

                const dialog = form.closest('[data-dialog]');

                if (dialog) {
                    closeDialog(dialog);
                }

                showToast(data.message ?? 'Agendamento realizado!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } catch {
                showToast('Não foi possível agendar.', 'error');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        });
    });
});
