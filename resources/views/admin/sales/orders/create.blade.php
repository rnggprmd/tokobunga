@extends('admin.layouts.app')
@section('title', 'Tambah Order Manual')
@section('subtitle', 'Buat pesanan baru secara manual')

@section('content')
<form action="{{ route('admin.orders.store') }}" method="POST" id="order-form">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Order & Customer Info --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card rounded-2xl p-6 space-y-4">
                <h3 class="font-semibold flex items-center gap-2 text-accent-emerald text-sm">
                    <span class="material-symbols-outlined">person</span> Informasi Pelanggan
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Pilih User Terdaftar (Opsional)</label>
                        <select name="user_id" id="user_id" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                            <option value="">-- Pilih Customer (Walk-in) --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->no_hp }}" data-address="{{ $user->alamat }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2 border-t border-admin-border border-dashed"></div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Nama Penerima</label>
                        <input type="text" name="customer_name" id="customer_name" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Email</label>
                        <input type="email" name="customer_email" id="customer_email"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">No. HP / WhatsApp</label>
                        <input type="text" name="customer_phone" id="customer_phone"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Alamat Lengkap</label>
                        <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="2"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none"></textarea>
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Pesan Kartu Ucapan (Opsional)</label>
                        <textarea name="ucapan" id="ucapan" rows="3" placeholder="Contoh: Happy Birthday! Dari: Budi"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none"></textarea>
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                            <option value="Cash">Cash / Offline</option>
                            <option value="Transfer">Bank Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Order Items --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-admin-border flex justify-between items-center bg-white/50">
                    <h3 class="font-semibold flex items-center gap-2 text-sm uppercase tracking-wider">
                        <span class="material-symbols-outlined text-accent-emerald">receipt_long</span> Daftar Barang / Item
                    </h3>
                    <button type="button" id="add-item-btn" class="text-xs bg-accent-emerald text-white px-3 py-1.5 rounded-lg flex items-center gap-1 hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-sm">add</span> Tambah Baris
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="items-table">
                        <thead>
                            <tr class="text-text-muted text-[10px] uppercase tracking-[0.1em] bg-admin-bg/50">
                                <th class="text-left px-6 py-3 w-1/2">Produk</th>
                                <th class="text-left px-6 py-3">Varian & Jumlah</th>
                                <th class="text-right px-6 py-3">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-admin-border/50">
                            {{-- Row Template in JS --}}
                        </tbody>
                        <tfoot>
                            <tr class="bg-accent-emerald/5 font-bold">
                                <td colspan="2" class="px-6 py-4 text-right text-text-muted uppercase text-[10px] tracking-widest">Total Bayar:</td>
                                <td class="px-6 py-4 text-right text-lg text-accent-emerald" id="grand-total">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2.5 bg-admin-bg border border-admin-border rounded-xl text-sm font-semibold hover:bg-admin-card-hover transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-accent-emerald text-white rounded-xl text-sm font-bold shadow-lg shadow-accent-emerald/20 hover:opacity-90 transition-opacity">
                    Simpan & Buat Order
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Data for JS --}}
<script>
    const productsData = @json($products);
</script>

@push('scripts')
<script>
    const itemsTableBody = document.querySelector('#items-table tbody');
    const addItemBtn = document.querySelector('#add-item-btn');
    const grandTotalEl = document.querySelector('#grand-total');
    const userSelect = document.querySelector('#user_id');

    let rowCount = 0;

    // Handle User selection
    userSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (this.value) {
            document.getElementById('customer_name').value = option.dataset.name;
            document.getElementById('customer_email').value = option.dataset.email;
            document.getElementById('customer_phone').value = option.dataset.phone;
            document.getElementById('alamat_pengiriman').value = option.dataset.address;
        }
    });

    function addItemRow() {
        const row = document.createElement('tr');
        row.className = 'hover:bg-admin-card-hover/20 transition-colors order-item-row';
        row.dataset.index = rowCount;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        productsData.forEach(p => {
            productOptions += `<option value="${p.id}" data-price="${p.harga}">${p.nama_produk} (Rp ${new Intl.NumberFormat('id-ID').format(p.harga)})</option>`;
        });

        row.innerHTML = `
            <td class="px-6 py-4">
                <select name="items[${rowCount}][product_id]" class="w-full bg-white border border-admin-border rounded-xl px-3 py-2 text-sm product-select" required>
                    ${productOptions}
                </select>
            </td>
            <td class="px-6 py-4">
                <div class="flex gap-2 items-center">
                    <select name="items[${rowCount}][variant_id]" class="w-full bg-white border border-admin-border rounded-xl px-3 py-2 text-xs variant-select" disabled>
                        <option value="">Standard</option>
                    </select>
                    <input type="number" name="items[${rowCount}][jumlah]" value="1" min="1" class="w-20 bg-white border border-admin-border rounded-xl px-3 py-2 text-sm text-center quantity-input" required>
                </div>
            </td>
            <td class="px-6 py-4 text-right font-medium row-subtotal">Rp 0</td>
            <td class="px-4 py-4 text-center">
                <button type="button" class="text-accent-rose hover:bg-accent-rose/10 p-1.5 rounded-lg transition-colors remove-item-btn">
                    <span class="material-symbols-outlined text-lg">delete</span>
                </button>
            </td>
        `;

        itemsTableBody.appendChild(row);

        const pSelect = row.querySelector('.product-select');
        const vSelect = row.querySelector('.variant-select');
        const qInput = row.querySelector('.quantity-input');
        const removeBtn = row.querySelector('.remove-item-btn');

        pSelect.addEventListener('change', () => updateRowPrice(row));
        vSelect.addEventListener('change', () => updateRowPrice(row));
        qInput.addEventListener('input', () => updateRowPrice(row));
        removeBtn.addEventListener('click', () => {
            row.remove();
            calculateGrandTotal();
        });

        rowCount++;
    }

    function updateRowPrice(row) {
        const pSelect = row.querySelector('.product-select');
        const vSelect = row.querySelector('.variant-select');
        const qInput = row.querySelector('.quantity-input');
        const subtotalEl = row.querySelector('.row-subtotal');

        const productId = pSelect.value;
        if (!productId) {
            subtotalEl.textContent = 'Rp 0';
            vSelect.innerHTML = '<option value="">Standard</option>';
            vSelect.disabled = true;
            calculateGrandTotal();
            return;
        }

        const product = productsData.find(p => p.id == productId);
        let price = parseFloat(product.harga);

        // Update Variants
        if (product.variants && product.variants.length > 0) {
            const currentVariantId = vSelect.value;
            vSelect.disabled = false;
            let vOptions = '<option value="" data-adj="0">Standard</option>';
            product.variants.forEach(v => {
                vOptions += `<option value="${v.id}" data-adj="${v.price_adjustment}" ${currentVariantId == v.id ? 'selected' : ''}>${v.size} (+ Rp ${new Intl.NumberFormat('id-ID').format(v.price_adjustment)})</option>`;
            });
            vSelect.innerHTML = vOptions;

            const selectedVariant = vSelect.options[vSelect.selectedIndex];
            if (selectedVariant) {
                price += parseFloat(selectedVariant.dataset.adj || 0);
            }
        } else {
            vSelect.innerHTML = '<option value="" data-adj="0">Standard</option>';
            vSelect.disabled = true;
        }

        const subtotal = price * parseInt(qInput.value || 0);
        subtotalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        subtotalEl.dataset.value = subtotal;

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.row-subtotal').forEach(el => {
            total += parseFloat(el.dataset.value || 0);
        });
        grandTotalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    // Default: 1 row
    addItemBtn.addEventListener('click', addItemRow);
    addItemRow();
</script>
@endpush
@endsection
