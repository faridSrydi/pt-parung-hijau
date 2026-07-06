/**
 * PT Parung Hijau Perkasa - Dashboard Admin & Staff Helper JS
 */

// Global Modal Helper to safely open Bootstrap Modals
function showModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    if (typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    } else {
        let btn = document.getElementById('btn-trigger-' + modalId);
        if (!btn) {
            btn = document.createElement('button');
            btn.id = 'btn-trigger-' + modalId;
            btn.style.display = 'none';
            btn.setAttribute('data-bs-toggle', 'modal');
            btn.setAttribute('data-bs-target', '#' + modalId);
            document.body.appendChild(btn);
        }
        btn.click();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Sidebar active state — client-side highlight based on current URL
    const path = window.location.pathname.replace(/\/$/, '');
    const links = document.querySelectorAll('#sidebar a.nav-link');
    links.forEach(function(link) {
        const href = link.getAttribute('href');
        if (!href || href === '#') return;
        try {
            const linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '');
            if (path === linkPath) {
                link.classList.add('active');
                link.style.backgroundColor = '#e0f2fe';
                link.style.color = '#0284c7';
                link.style.borderRadius = '6px';
                link.style.fontWeight = '600';
                const icon = link.querySelector('i');
                if (icon) icon.style.color = '#0284c7';
            }
        } catch(e) { console.error(e); }
    });

    // 2. Kelola Akun - Populate Edit Modal
    const editAkunButtons = document.querySelectorAll('.btn-edit-akun');
    editAkunButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const editIdInput = document.getElementById('edit-id');
            const editNamaInput = document.getElementById('edit-nama');
            const editEmailInput = document.getElementById('edit-email');
            const editRoleSelect = document.getElementById('edit-role');
            const editStatusSelect = document.getElementById('edit-status');

            if (editIdInput) editIdInput.value = id;
            if (editNamaInput) editNamaInput.value = this.dataset.nama;
            if (editEmailInput) editEmailInput.value = this.dataset.email;
            if (editRoleSelect) editRoleSelect.value = this.dataset.role;
            if (editStatusSelect) editStatusSelect.value = this.dataset.status;

            const form = document.getElementById('form-edit-akun');
            if (form) {
                const baseUrl = form.getAttribute('data-base-url') || '';
                form.action = baseUrl + 'admin/akun/edit/' + id;
            }
            
            showModal('modalEditAkun');
        });
    });

    // 3. Kelola Unit - Populate Edit Modal
    const editUnitButtons = document.querySelectorAll('.btn-edit-unit');
    editUnitButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const editIdInput = document.getElementById('edit-id');
            const editNamaInput = document.getElementById('edit-nama');
            const editTaglineInput = document.getElementById('edit-tagline');
            const editWilayahInput = document.getElementById('edit-wilayah');
            const editKomoditasInput = document.getElementById('edit-komoditas');
            const editKapasitasInput = document.getElementById('edit-kapasitas');
            const editDeskripsiInput = document.getElementById('edit-deskripsi');
            const editAlamatInput = document.getElementById('edit-alamat');
            const editPhoneInput = document.getElementById('edit-phone');
            const editHariInput = document.getElementById('edit-hari');
            const editJamBukaInput = document.getElementById('edit-jam-buka');
            const editJamTutupInput = document.getElementById('edit-jam-tutup');
            const editMapsInput = document.getElementById('edit-maps');

            if (editIdInput) editIdInput.value = id;
            if (editNamaInput) editNamaInput.value = this.dataset.nama;
            if (editTaglineInput) editTaglineInput.value = this.dataset.tagline;
            if (editWilayahInput) editWilayahInput.value = this.dataset.wilayah;
            if (editKomoditasInput) editKomoditasInput.value = this.dataset.komoditas;
            if (editKapasitasInput) editKapasitasInput.value = this.dataset.kapasitas;
            if (editDeskripsiInput) editDeskripsiInput.value = this.dataset.deskripsi;
            if (editAlamatInput) editAlamatInput.value = this.dataset.alamat;
            if (editPhoneInput) editPhoneInput.value = this.dataset.phone;
            
            const jamStr = this.dataset.jam || '';
            let hari = jamStr;
            let jamBuka = '';
            let jamTutup = '';
            
            if (jamStr.includes(',')) {
                const parts = jamStr.split(',');
                hari = parts[0].trim();
                const timePart = parts.slice(1).join(',').replace('WIB', '').trim();
                const times = timePart.split(/[-–]/);
                if (times.length >= 2) {
                    jamBuka = times[0].trim().replace('.', ':');
                    jamTutup = times[1].trim().replace('.', ':');
                    // HTML time inputs require HH:mm format
                    if (jamBuka.length === 4) jamBuka = '0' + jamBuka;
                    if (jamTutup.length === 4) jamTutup = '0' + jamTutup;
                }
            }

            if (editHariInput) editHariInput.value = hari;
            if (editJamBukaInput) editJamBukaInput.value = jamBuka;
            if (editJamTutupInput) editJamTutupInput.value = jamTutup;
            if (editMapsInput) editMapsInput.value = this.dataset.maps;
            
            const form = document.getElementById('form-edit-unit');
            const baseUrl = form ? (form.getAttribute('data-base-url') || '') : '';
            if (form) {
                form.action = baseUrl + 'admin/unit/edit/' + id;
            }
            
            if (typeof editUnitGalleryMgr !== 'undefined') {
                editUnitGalleryMgr.reset();
                editUnitGalleryMgr.loadFotoPreview(this.dataset.foto, baseUrl);
                editUnitGalleryMgr.loadExisting(this.dataset.gallery, baseUrl);
            }
            
            showModal('modalEditUnit');
        });
    });

    // 4. Kelola Produk - Gallery Manager Class
    class GalleryManager {
        constructor(fotoInputId, fotoPreviewId, galleryInputId, galleryPreviewId, orderInputId) {
            this.fotoInput = document.getElementById(fotoInputId);
            this.fotoPreview = document.getElementById(fotoPreviewId);
            this.galleryInput = document.getElementById(galleryInputId);
            this.galleryPreview = document.getElementById(galleryPreviewId);
            this.orderInput = document.getElementById(orderInputId);
            
            this.items = []; // { type: 'existing'|'new', path?, file? }
            this.sortableInstance = null;

            this._bindEvents();
        }

        _bindEvents() {
            if (this.fotoInput) {
                this.fotoInput.addEventListener('change', (e) => this._onFotoChange(e));
            }
            if (this.galleryInput) {
                this.galleryInput.addEventListener('change', (e) => this._onGalleryChange(e));
            }
        }

        _initSortable() {
            if (this.sortableInstance) this.sortableInstance.destroy();
            if (this.galleryPreview && typeof Sortable !== 'undefined') {
                this.sortableInstance = Sortable.create(this.galleryPreview, {
                    animation: 200,
                    ghostClass: 'gallery-sort-ghost',
                    onEnd: () => this._syncFromDOM()
                });
            }
        }

        _onFotoChange(e) {
            if (!this.fotoPreview) return;
            this.fotoPreview.innerHTML = '';
            this.fotoPreview.style.display = 'none';
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                this.fotoPreview.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;">`;
                this.fotoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        _onGalleryChange(e) {
            const files = Array.from(e.target.files);
            files.forEach(f => this.items.push({ type: 'new', file: f }));
            this._render();
        }

        loadExisting(galleryJson, baseUrl) {
            this.items = [];
            this.baseUrl = baseUrl || '';
            try {
                const arr = JSON.parse(galleryJson || '[]');
                if (Array.isArray(arr)) {
                    arr.forEach(path => {
                        if (path) this.items.push({ type: 'existing', path: path });
                    });
                }
            } catch(e) { /* ignore parse error */ }
            this._render();
        }

        loadFotoPreview(fotoPath, baseUrl) {
            if (!this.fotoPreview || !fotoPath) return;
            this.fotoPreview.innerHTML = `<img src="${baseUrl}${fotoPath}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;">`;
            this.fotoPreview.style.display = 'block';
        }

        reset() {
            this.items = [];
            if (this.fotoPreview) { this.fotoPreview.innerHTML = ''; this.fotoPreview.style.display = 'none'; }
            if (this.galleryPreview) this.galleryPreview.innerHTML = '';
            if (this.orderInput) this.orderInput.value = '';
            if (this.galleryInput) this.galleryInput.value = '';
            if (this.fotoInput) this.fotoInput.value = '';
        }

        _render() {
            if (!this.galleryPreview) return;
            this.galleryPreview.innerHTML = '';

            this.items.forEach((item, idx) => {
                const card = document.createElement('div');
                card.className = 'gallery-preview-card';
                card.dataset.idx = idx;
                Object.assign(card.style, {
                    position: 'relative', width: '80px', height: '80px',
                    borderRadius: '8px', overflow: 'hidden', cursor: 'grab',
                    border: '2px solid #e2e8f0', flexShrink: '0',
                    transition: 'box-shadow 0.2s'
                });

                const img = document.createElement('img');
                Object.assign(img.style, { width: '100%', height: '100%', objectFit: 'cover', display: 'block' });

                if (item.type === 'existing') {
                    img.src = this.baseUrl + item.path;
                    card.appendChild(img);
                } else {
                    const reader = new FileReader();
                    reader.onload = (ev) => { img.src = ev.target.result; };
                    reader.readAsDataURL(item.file);
                    card.appendChild(img);
                }

                // Remove button
                const rmBtn = document.createElement('div');
                rmBtn.innerHTML = '×';
                Object.assign(rmBtn.style, {
                    position: 'absolute', top: '2px', right: '2px',
                    background: 'rgba(220,38,38,0.85)', color: '#fff',
                    borderRadius: '50%', width: '20px', height: '20px',
                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                    cursor: 'pointer', fontSize: '13px', fontWeight: 'bold',
                    lineHeight: '1', boxShadow: '0 1px 3px rgba(0,0,0,0.3)'
                });
                rmBtn.onclick = (e) => {
                    e.stopPropagation();
                    this.items.splice(idx, 1);
                    this._render();
                };
                card.appendChild(rmBtn);

                // Order badge
                const badge = document.createElement('div');
                badge.textContent = idx + 1;
                Object.assign(badge.style, {
                    position: 'absolute', bottom: '2px', left: '2px',
                    background: 'rgba(0,0,0,0.6)', color: '#fff',
                    borderRadius: '4px', padding: '1px 5px',
                    fontSize: '10px', fontWeight: 'bold'
                });
                card.appendChild(badge);

                this.galleryPreview.appendChild(card);
            });

            this._initSortable();
            this._updateOrder();
        }

        /** After drag-and-drop, sync the items array to match the new DOM order */
        _syncFromDOM() {
            if (!this.galleryPreview) return;
            const nodes = Array.from(this.galleryPreview.children);
            const reordered = nodes.map(n => this.items[parseInt(n.dataset.idx)]);
            this.items = reordered;
            this._render(); // re-render to update idx and badges
        }

        _updateOrder() {
            if (!this.orderInput) return;
            const order = this.items.map(item => {
                if (item.type === 'existing') return { type: 'existing', path: item.path };
                return { type: 'new' };
            });
            this.orderInput.value = JSON.stringify(order);
        }

        /** Call before form submit to rewrite the file input with only 'new' files in correct order */
        prepareSubmit() {
            this._updateOrder();
            if (this.galleryInput) {
                const dt = new DataTransfer();
                this.items.forEach(item => {
                    if (item.type === 'new') dt.items.add(item.file);
                });
                this.galleryInput.files = dt.files;
            }
        }
    }

    // Instantiate Gallery Managers (Produk)
    const addGalleryMgr = new GalleryManager(
        'add-foto-produk', 'add-foto-preview',
        'add-gallery-produk', 'add-gallery-preview', 'add-gallery-order'
    );

    const editGalleryMgr = new GalleryManager(
        'edit-foto-produk', 'edit-foto-preview',
        'edit-gallery-produk', 'edit-gallery-preview', 'edit-gallery-order'
    );

    // Instantiate Gallery Managers (Unit)
    window.addUnitGalleryMgr = new GalleryManager(
        'add-foto-sampul', 'add-foto-preview',
        'add-gallery-unit', 'add-gallery-preview', 'add-gallery-order'
    );

    window.editUnitGalleryMgr = new GalleryManager(
        'edit-foto-sampul', 'edit-foto-preview',
        'edit-gallery-unit', 'edit-gallery-preview', 'edit-gallery-order'
    );

    // Intercept form submissions
    const addForm = document.querySelector('#modalTambahProduk form');
    if (addForm) {
        addForm.addEventListener('submit', () => addGalleryMgr.prepareSubmit());
    }
    const editForm = document.getElementById('form-edit-produk');
    if (editForm) {
        editForm.addEventListener('submit', () => editGalleryMgr.prepareSubmit());
    }

    const addUnitForm = document.querySelector('#modalTambahUnit form');
    if (addUnitForm) {
        addUnitForm.addEventListener('submit', () => addUnitGalleryMgr.prepareSubmit());
    }
    const editUnitForm = document.getElementById('form-edit-unit');
    if (editUnitForm) {
        editUnitForm.addEventListener('submit', () => editUnitGalleryMgr.prepareSubmit());
    }

    // Reset add modal on close
    const addModal = document.getElementById('modalTambahProduk');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', () => addGalleryMgr.reset());
    }
    
    const addUnitModal = document.getElementById('modalTambahUnit');
    if (addUnitModal) {
        addUnitModal.addEventListener('hidden.bs.modal', () => addUnitGalleryMgr.reset());
    }

    // Populate Edit Modal
    const editProdukButtons = document.querySelectorAll('.btn-edit-produk');
    editProdukButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const editNamaInput = document.getElementById('edit-nama');
            const editUnitSelect = document.getElementById('edit-unit');
            const editParentSelect = document.getElementById('edit-parent');
            const editHargaInput = document.getElementById('edit-harga');
            const editSatuanSelect = document.getElementById('edit-satuan');
            const editStokInput = document.getElementById('edit-stok');
            const editSingkatInput = document.getElementById('edit-singkat');
            const editLengkapInput = document.getElementById('edit-lengkap');

            if (editNamaInput) editNamaInput.value = this.dataset.nama;
            if (editUnitSelect) editUnitSelect.value = this.dataset.unit;
            if (editParentSelect) editParentSelect.value = this.dataset.parent;
            if (editHargaInput) editHargaInput.value = this.dataset.harga;
            if (editSatuanSelect) editSatuanSelect.value = this.dataset.satuan;
            if (editStokInput) editStokInput.value = this.dataset.stok;
            if (editSingkatInput) editSingkatInput.value = this.dataset.singkat;
            if (editLengkapInput) editLengkapInput.value = this.dataset.lengkap;

            const form = document.getElementById('form-edit-produk');
            const baseUrl = form ? (form.getAttribute('data-base-url') || '') : '';
            if (form) {
                form.action = baseUrl + 'admin/produk/edit/' + id;
            }

            // Load existing foto preview
            editGalleryMgr.reset();
            editGalleryMgr.loadFotoPreview(this.dataset.foto, baseUrl);
            editGalleryMgr.loadExisting(this.dataset.gallery, baseUrl);

            showModal('modalEditProduk');
        });
    });

    // 5. Kelola Supir - Populate Edit Modal
    const editSupirButtons = document.querySelectorAll('.btn-edit-supir');
    editSupirButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const editIdInput = document.getElementById('edit-id');
            const editNamaInput = document.getElementById('edit-nama');
            const editPhoneInput = document.getElementById('edit-phone');
            const editArmadaSelect = document.getElementById('edit-armada');
            const editPlatInput = document.getElementById('edit-plat');

            if (editIdInput) editIdInput.value = id;
            if (editNamaInput) editNamaInput.value = this.dataset.nama;
            if (editPhoneInput) editPhoneInput.value = this.dataset.phone;
            if (editArmadaSelect) editArmadaSelect.value = this.dataset.armada;
            if (editPlatInput) editPlatInput.value = this.dataset.plat;

            const form = document.getElementById('form-edit-supir');
            if (form) {
                const baseUrl = form.getAttribute('data-base-url') || '';
                form.action = baseUrl + 'admin/supir/edit/' + id;
            }
            
            showModal('modalEditSupir');
        });
    });

    // 6. Produksi Input - Product Category Filter Mapping
    const unitSelect = document.getElementById('unit-bisnis');
    const productSelect = document.getElementById('produk');
    const unitLabel = document.getElementById('volume-unit-label');

    if (unitSelect && productSelect && unitLabel) {
        const initialProducts = Array.from(productSelect.options);

        unitSelect.addEventListener('change', function() {
            const selectedUnit = this.value;
            productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
            
            initialProducts.forEach(opt => {
                if (!opt.value) return;
                const unit = opt.getAttribute('data-unit');
                if (!selectedUnit || unit === selectedUnit) {
                    productSelect.appendChild(opt.cloneNode(true));
                }
            });
            unitLabel.textContent = 'Satuan';
        });

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                unitLabel.textContent = selectedOption.getAttribute('data-satuan') || 'Satuan';
            } else {
                unitLabel.textContent = 'Satuan';
            }
        });
    }
});

// Global Confirmation Helpers
window.confirmDelete = function(url, message) {
    const modalEl = document.getElementById('modalConfirmDelete');
    if (modalEl) {
        document.getElementById('deleteModalMessage').textContent = message || 'Apakah Anda yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.';
        document.getElementById('btnConfirmDeleteAction').href = url;
        showModal('modalConfirmDelete');
    } else {
        // Fallback
        if (confirm(message || 'Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = url;
        }
    }
};
