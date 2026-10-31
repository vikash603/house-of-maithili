@php
    $isEdit = isset($product) && $product;
    $formProduct = $isEdit ? $product : null;
    $initialVariants = $isEdit ? $product->variants->map(fn ($variant) => [
        'size' => $variant->size,
        'color' => $variant->color,
        'sku' => $variant->sku,
        'price' => $variant->price,
        'sale_price' => $variant->sale_price,
        'stock' => $variant->stock,
        'is_active' => $variant->is_active,
    ])->values() : collect();
    $hasVariants = old('has_variants', $initialVariants->isNotEmpty() ? '1' : '0') === '1';
@endphp

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>Product details need attention.</strong>
        <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form id="product-form" action="{{ $isEdit ? route('products.update', $product) : route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <input type="hidden" name="has_variants" value="0">

    <div class="catalog-card">
        <div class="catalog-card-header"><h4>Product information</h4><span class="catalog-help">Core details shoppers use to find this item.</span></div>
        <div class="catalog-card-body">
            <div class="form-row">
                <div class="form-group col-lg-8">
                    <label class="catalog-label" for="product-name">Product name <span class="catalog-required">*</span></label>
                    <input id="product-name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $formProduct?->name) }}" maxlength="255" required placeholder="e.g. Hand painted Madhubani lehenga">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-lg-4">
                    <label class="catalog-label" for="product-sku">Product/style SKU</label>
                    <input id="product-sku" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{ old('sku', $formProduct?->sku) }}" maxlength="100" placeholder="Auto-generated if empty">
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="catalog-label" for="product-brand">Brand / collection</label>
                    <input id="product-brand" class="form-control" name="brand" value="{{ old('brand', $formProduct?->brand) }}" maxlength="120" placeholder="House Of Maithili">
                </div>
                <div class="form-group col-md-6">
                    <label class="catalog-label" for="product-category">Category <span class="catalog-required">*</span></label>
                    <select id="product-category" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $formProduct?->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="catalog-label" for="product-subcategory">Subcategory</label>
                    <select id="product-subcategory" name="subcategory_id" class="form-control">
                        <option value="">No subcategory</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" @selected(old('subcategory_id', $formProduct?->subcategory_id) == $subcategory->id)>{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12">
                    <label class="catalog-label" for="short-description">Short description</label>
                    <input id="short-description" name="short_description" class="form-control" maxlength="500" value="{{ old('short_description', $formProduct?->short_description) }}" placeholder="A concise product summary">
                </div>
                <div class="form-group col-12">
                    <label class="catalog-label" for="product-description">Product description</label>
                    <textarea id="product-description" name="description" rows="5" class="form-control" placeholder="Materials, craft details and care information">{{ old('description', $formProduct?->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="catalog-card">
        <div class="catalog-card-header"><h4>Product images</h4><span class="catalog-help">Use clear, high quality images. JPG, PNG or WebP · up to 5 MB each.</span></div>
        <div class="catalog-card-body">
            @if ($formProduct?->thumbnail)
                <div class="catalog-existing-image"><img src="{{ asset('uploads/products/'.$formProduct->thumbnail) }}" alt="Current product cover"><span>Current cover image<br><small class="text-muted">Upload a new cover to replace it.</small></span></div>
            @endif
            <div class="form-group">
                <label class="catalog-label" for="thumbnail">Cover image</label>
                <input id="thumbnail" type="file" name="thumbnail" class="form-control-file" accept="image/jpeg,image/png,image/webp">
                <div id="cover-preview" class="catalog-image-preview"></div>
            </div>
            @if ($formProduct?->images->isNotEmpty())
                <div class="form-group"><label class="catalog-label">Gallery images</label><div class="catalog-image-preview">
                    @foreach ($formProduct->images as $image)
                        <div class="text-center" id="product-image-{{ $image->id }}">
                            <img src="{{ asset('uploads/products/'.$image->image) }}" alt="Product gallery image">
                            <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="deleteProductImage({{ $image->id }})">Remove</button>
                        </div>
                    @endforeach
                </div></div>
            @endif
            <div class="form-group mb-0">
                <label class="catalog-label" for="images">Add gallery images</label>
                <input id="images" type="file" name="images[]" class="form-control-file" accept="image/jpeg,image/png,image/webp" multiple>
                <small class="catalog-help">You can add up to 12 gallery images. The first image is shown as the product cover if no cover is set.</small>
                <div id="gallery-preview" class="catalog-image-preview"></div>
            </div>
        </div>
    </div>

    <div class="catalog-card">
        <div class="catalog-card-header"><h4>Pricing &amp; availability</h4></div>
        <div class="catalog-card-body">
            <div class="form-row align-items-end">
                <div class="form-group col-md-4">
                    <label class="catalog-label" for="base-price">Base price (₹) <span class="catalog-required">*</span></label>
                    <input id="base-price" type="number" min="0" step="0.01" name="price" class="form-control" value="{{ old('price', $formProduct?->price) }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="catalog-label" for="base-sale-price">Sale price (₹)</label>
                    <input id="base-sale-price" type="number" min="0" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $formProduct?->sale_price) }}">
                </div>
                <div class="form-group col-md-4" id="simple-stock-field" @if($hasVariants) hidden @endif>
                    <label class="catalog-label" for="simple-stock">Available stock</label>
                    <input id="simple-stock" type="number" min="0" name="stock" class="form-control" value="{{ old('stock', $formProduct?->stock ?? 0) }}" @if($hasVariants) disabled @endif>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="catalog-label" for="product-status">Listing status</label>
                    <select id="product-status" name="status" class="form-control"><option value="1" @selected(old('status', $formProduct?->status ?? 1) == 1)>Active</option><option value="0" @selected(old('status', $formProduct?->status ?? 1) == 0)>Draft / hidden</option></select>
                </div>
                <div class="form-group col-md-6">
                    <label class="catalog-label d-block">Storefront placement</label>
                    <label class="mr-3"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $formProduct?->is_featured))> Featured</label>
                    <label><input type="checkbox" name="is_trending" value="1" @checked(old('is_trending', $formProduct?->is_trending))> Trending</label>
                </div>
            </div>

            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="made-to-order" name="is_made_to_order" value="1" @checked(old('is_made_to_order', $formProduct?->is_made_to_order))>
                <label class="custom-control-label catalog-label" for="made-to-order">Made to order</label>
            </div>
            <div class="form-row" id="lead-time-field" @if(!old('is_made_to_order', $formProduct?->is_made_to_order)) hidden @endif>
                <div class="form-group col-md-4 mb-0">
                    <label class="catalog-label" for="lead-time-days">Crafting &amp; dispatch time (working days)</label>
                    <input id="lead-time-days" type="number" name="lead_time_days" min="1" max="120" class="form-control" value="{{ old('lead_time_days', $formProduct?->lead_time_days ?? 15) }}">
                    <small class="catalog-help">Customers can order selected sizes even when ready stock is zero.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="catalog-card">
        <div class="catalog-card-header"><h4>Size &amp; colour variants</h4><span class="catalog-help">Create one SKU and stock count for every size/colour combination.</span></div>
        <div class="catalog-card-body">
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="has-variants" name="has_variants" value="1" @checked($hasVariants)>
                <label class="custom-control-label catalog-label" for="has-variants">This product has size or colour options</label>
            </div>
            <fieldset id="variant-fieldset" @disabled(!$hasVariants)>
                <div class="form-group">
                    <span class="catalog-label d-block">Choose sizes</span>
                    <div id="size-options" class="catalog-size-options">
                        @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'] as $size)
                            <label class="catalog-size-option"><input type="checkbox" value="{{ $size }}"> {{ $size }}</label>
                        @endforeach
                    </div>
                    <div class="form-row">
                        <div class="col-md-5"><input id="custom-size" class="form-control" placeholder="Add another size (e.g. 4XL)"></div>
                        <div class="col-md-3 mt-2 mt-md-0"><button id="add-custom-size" type="button" class="btn btn-outline-secondary btn-block">Add size</button></div>
                    </div>
                </div>

                <div class="form-group">
                    <span class="catalog-label d-block">Add colours</span>
                    <div id="color-list" class="catalog-color-list"></div>
                    <div class="form-row align-items-center">
                        <div class="col-sm-5 mb-2 mb-sm-0"><input id="new-color-name" class="form-control" placeholder="Colour name, e.g. Maroon"></div>
                        <div class="col-sm-2 mb-2 mb-sm-0"><input id="new-color-hex" type="color" class="form-control" value="#762b3a" title="Choose colour"></div>
                        <div class="col-sm-3"><button id="add-color" type="button" class="btn btn-outline-secondary btn-block">Add colour</button></div>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                    <div><strong>Variant inventory</strong><small class="d-block text-muted">Add at least one size or colour, then generate the combinations.</small></div>
                    <button id="generate-variants" type="button" class="btn btn-outline-primary mt-2 mt-md-0">Generate combinations</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm catalog-variant-table">
                        <thead><tr><th>Size</th><th>Colour</th><th>Variant SKU</th><th>Price ₹</th><th>Sale ₹</th><th>Stock</th><th>Available</th><th></th></tr></thead>
                        <tbody id="variant-grid"></tbody>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="catalog-sticky-actions">
        <a href="{{ route('products.index') }}" class="btn btn-light">Cancel</a>
        <button type="submit" class="btn btn-primary px-4">{{ $isEdit ? 'Save changes' : 'Save product' }}</button>
    </div>
</form>

@section('js')
<script>
(() => {
    const form = document.getElementById('product-form');
    const variantToggle = document.getElementById('has-variants');
    const variantFieldset = document.getElementById('variant-fieldset');
    const variantGrid = document.getElementById('variant-grid');
    const colors = [];
    let nextVariantIndex = 0;
    let variants = @json($initialVariants);

    const addColorChip = (name, hex) => {
        if (!name || colors.some(color => color.name.toLowerCase() === name.toLowerCase())) return;
        colors.push({ name, hex });
        const chip = document.createElement('span');
        chip.className = 'catalog-color-chip';
        const swatch = document.createElement('i');
        swatch.style.backgroundColor = hex;
        const label = document.createElement('span');
        label.textContent = name;
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'btn btn-link btn-sm p-0 ml-1 text-muted';
        remove.setAttribute('aria-label', 'Remove '+name);
        remove.textContent = '×';
        remove.addEventListener('click', () => {
            const index = colors.findIndex(color => color.name === name);
            if (index >= 0) colors.splice(index, 1);
            chip.remove();
        });
        chip.append(swatch, label, remove);
        document.getElementById('color-list').appendChild(chip);
    };

    const input = (name, value, type = 'text', options = {}) => {
        const field = document.createElement('input');
        field.name = name;
        field.value = value ?? '';
        field.type = type;
        field.className = 'form-control';
        if (type === 'number') {
            field.min = options.min ?? '0';
            field.step = options.step ?? '0.01';
        }
        if (options.required) field.required = true;
        return field;
    };

    const renderVariant = (variant = {}) => {
        const index = nextVariantIndex++;
        const row = document.createElement('tr');
        const sizeCell = document.createElement('td');
        const colorCell = document.createElement('td');
        const skuCell = document.createElement('td');
        const priceCell = document.createElement('td');
        const saleCell = document.createElement('td');
        const stockCell = document.createElement('td');
        const activeCell = document.createElement('td');
        const actionCell = document.createElement('td');
        sizeCell.append(input(`variants[${index}][size]`, variant.size));
        colorCell.append(input(`variants[${index}][color]`, variant.color));
        skuCell.append(input(`variants[${index}][sku]`, variant.sku));
        priceCell.append(input(`variants[${index}][price]`, variant.price ?? document.getElementById('base-price').value, 'number'));
        saleCell.append(input(`variants[${index}][sale_price]`, variant.sale_price, 'number'));
        stockCell.append(input(`variants[${index}][stock]`, variant.stock ?? 0, 'number', { step: '1', required: true }));
        const active = document.createElement('select');
        active.name = `variants[${index}][is_active]`;
        active.className = 'form-control';
        [['1','Yes'], ['0','No']].forEach(([value, text]) => {
            const option = document.createElement('option'); option.value = value; option.textContent = text;
            if (String(variant.is_active ?? true) === value || (value === '1' && variant.is_active === true)) option.selected = true;
            active.appendChild(option);
        });
        activeCell.append(active);
        const remove = document.createElement('button');
        remove.type = 'button'; remove.className = 'btn btn-sm btn-outline-danger'; remove.textContent = 'Remove';
        remove.addEventListener('click', () => row.remove());
        actionCell.append(remove);
        row.append(sizeCell, colorCell, skuCell, priceCell, saleCell, stockCell, activeCell, actionCell);
        variantGrid.appendChild(row);
    };

    const checkedSizes = () => Array.from(document.querySelectorAll('#size-options input:checked')).map(option => option.value);

    document.getElementById('add-custom-size').addEventListener('click', () => {
        const field = document.getElementById('custom-size');
        const value = field.value.trim();
        if (!value) return;
        if (Array.from(document.querySelectorAll('#size-options input')).some(option => option.value.toLowerCase() === value.toLowerCase())) return;
        const label = document.createElement('label'); label.className = 'catalog-size-option';
        const checkbox = document.createElement('input'); checkbox.type = 'checkbox'; checkbox.value = value; checkbox.checked = true;
        label.append(checkbox, document.createTextNode(' '+value));
        document.getElementById('size-options').appendChild(label);
        field.value = '';
    });

    document.getElementById('add-color').addEventListener('click', () => {
        const name = document.getElementById('new-color-name').value.trim();
        const hex = document.getElementById('new-color-hex').value;
        addColorChip(name, hex);
        document.getElementById('new-color-name').value = '';
    });

    document.getElementById('generate-variants').addEventListener('click', () => {
        const sizes = checkedSizes();
        const colorNames = colors.map(color => color.name);
        const axes = [sizes, colorNames].filter(axis => axis.length > 0);
        if (!axes.length) { alert('Select at least one size or add a colour first.'); return; }
        const combinations = axes.length === 1 ? axes[0].map(value => axes[0] === sizes ? [value, ''] : ['', value]) : sizes.flatMap(size => colorNames.map(color => [size, color]));
        if (combinations.length > 100) { alert('A product can have up to 100 variants. Reduce the selected sizes or colours.'); return; }

        const previous = new Map(Array.from(variantGrid.querySelectorAll('tr')).map(row => {
            const fields = row.querySelectorAll('input,select');
            return [`${fields[0].value.toLowerCase()}|${fields[1].value.toLowerCase()}`, {
                size: fields[0].value, color: fields[1].value, sku: fields[2].value, price: fields[3].value,
                sale_price: fields[4].value, stock: fields[5].value, is_active: fields[6].value
            }];
        }));
        variantGrid.replaceChildren(); nextVariantIndex = 0;
        combinations.forEach(([size, color]) => renderVariant(previous.get(`${size.toLowerCase()}|${color.toLowerCase()}`) || { size, color }));
    });

    variantToggle.addEventListener('change', () => {
        variantFieldset.disabled = !variantToggle.checked;
        document.getElementById('simple-stock-field').hidden = variantToggle.checked;
        document.getElementById('simple-stock').disabled = variantToggle.checked;
    });

    document.getElementById('made-to-order').addEventListener('change', function () {
        document.getElementById('lead-time-field').hidden = !this.checked;
    });

    const previewFiles = (fieldId, containerId) => {
        document.getElementById(fieldId).addEventListener('change', function () {
            const container = document.getElementById(containerId); container.replaceChildren();
            Array.from(this.files || []).forEach(file => {
                const image = document.createElement('img'); image.alt = file.name; image.src = URL.createObjectURL(file); container.append(image);
            });
        });
    };
    previewFiles('thumbnail', 'cover-preview');
    previewFiles('images', 'gallery-preview');

    document.getElementById('product-category').addEventListener('change', function () {
        const subcategory = document.getElementById('product-subcategory');
        subcategory.replaceChildren(new Option('No subcategory', ''));
        if (!this.value) return;
        fetch(@json(url('admin/get-subcategories')).replace(/\/$/, '')+'/'+this.value)
            .then(response => response.ok ? response.json() : [])
            .then(rows => rows.forEach(row => subcategory.add(new Option(row.name, row.id))))
            .catch(() => {});
    });

    if (variantToggle.checked) {
        const initialSizes = [...new Set(variants.map(variant => variant.size).filter(Boolean))];
        initialSizes.forEach(size => {
            let option = Array.from(document.querySelectorAll('#size-options input')).find(input => input.value.toLowerCase() === size.toLowerCase());
            if (!option) {
                const label = document.createElement('label'); label.className = 'catalog-size-option';
                option = document.createElement('input'); option.type = 'checkbox'; option.value = size;
                label.append(option, document.createTextNode(' '+size)); document.getElementById('size-options').appendChild(label);
            }
            option.checked = true;
        });
        [...new Set(variants.map(variant => variant.color).filter(Boolean))].forEach(color => addColorChip(color, '#762b3a'));
        variants.forEach(renderVariant);
    }

    form.addEventListener('submit', event => {
        if (variantToggle.checked && !variantGrid.querySelector('tr')) {
            event.preventDefault(); alert('Generate at least one size or colour variant before saving.');
        }
    });
})();

function deleteProductImage(id) {
    if (!confirm('Remove this gallery image?')) return;
    fetch(@json(url('admin/product-image')).replace(/\/$/, '')+'/'+id, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json'}
    }).then(response => response.json()).then(result => {
        if (result.success) document.getElementById('product-image-'+id)?.remove();
    });
}
</script>
@endsection
