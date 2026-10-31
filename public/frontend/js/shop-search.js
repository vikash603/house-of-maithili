(() => {
    const form = document.querySelector('.maithili-search-form');
    const input = form?.querySelector('input[name="q"]');
    const panel = form?.querySelector('#maithili-search-suggestions');
    if (!form || !input || !panel) return;

    let timer;
    let activeRequest;
    let sequence = 0;

    const closePanel = () => {
        panel.hidden = true;
        panel.replaceChildren();
        input.setAttribute('aria-expanded', 'false');
    };

    const addHeading = (label) => {
        const heading = document.createElement('p');
        heading.className = 'maithili-search-suggestion-heading';
        heading.textContent = label;
        panel.append(heading);
    };

    const addSuggestion = (item, category = false) => {
        const link = document.createElement('a');
        link.className = category ? 'maithili-search-suggestion maithili-search-category-suggestion' : 'maithili-search-suggestion';
        link.href = item.url;
        link.setAttribute('role', 'option');
        if (item.image) {
            const image = document.createElement('img');
            image.src = item.image;
            image.alt = '';
            image.loading = 'lazy';
            link.append(image);
        }
        const text = document.createElement('span');
        text.className = 'maithili-search-suggestion-name';
        text.textContent = item.name;
        link.append(text);
        if (item.price) {
            const price = document.createElement('span');
            price.className = 'maithili-search-suggestion-price';
            price.textContent = `₹${item.price}`;
            link.append(price);
        } else {
            const icon = document.createElement('span');
            icon.className = 'far fa-arrow-up-right-from-square';
            icon.setAttribute('aria-hidden', 'true');
            link.append(icon);
        }
        panel.append(link);
    };

    input.addEventListener('input', () => {
        window.clearTimeout(timer);
        if (activeRequest) activeRequest.abort();
        const term = input.value.trim();
        if (term.length < 2) return closePanel();

        timer = window.setTimeout(async () => {
            const requestId = ++sequence;
            activeRequest = new AbortController();
            try {
                const url = new URL(form.dataset.suggestionsUrl, window.location.origin);
                url.searchParams.set('q', term);
                const response = await fetch(url, {
                    headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    signal: activeRequest.signal,
                });
                if (!response.ok) throw new Error('Search suggestions unavailable');
                const data = await response.json();
                if (requestId !== sequence || input.value.trim() !== term) return;

                panel.replaceChildren();
                if (data.products?.length) {
                    addHeading('Products');
                    data.products.forEach((item) => addSuggestion(item));
                }
                if (data.categories?.length) {
                    addHeading('Categories');
                    data.categories.forEach((item) => addSuggestion(item, true));
                }
                if (!data.products?.length && !data.categories?.length) {
                    const empty = document.createElement('p');
                    empty.className = 'maithili-search-suggestion-empty';
                    empty.textContent = 'No matches yet. Press Enter to search the full catalogue.';
                    panel.append(empty);
                }
                const all = document.createElement('button');
                all.type = 'submit';
                all.className = 'maithili-search-all-results';
                all.textContent = `See all results for “${term}”`;
                panel.append(all);
                panel.hidden = false;
                input.setAttribute('aria-expanded', 'true');
            } catch (error) {
                if (error.name !== 'AbortError') closePanel();
            }
        }, 220);
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closePanel();
        if (event.key === 'ArrowDown' && !panel.hidden) {
            event.preventDefault();
            panel.querySelector('a')?.focus();
        }
    });
    panel.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closePanel();
            input.focus();
        }
    });
    form.addEventListener('submit', () => closePanel());
    document.addEventListener('click', (event) => {
        if (!form.contains(event.target)) closePanel();
    });
})();
