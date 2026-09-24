<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>API Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; }
        .header { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; align-items: center; gap: 1rem; }
        .header h1 { font-size: 1.5rem; font-weight: 700; color: #f1f5f9; }
        .badge { background: #6366f1; color: white; font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 9999px; font-weight: 600; }
        .container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: #1e293b; border: 1px solid #334155; border-radius: 0.75rem; padding: 1.5rem; }
        .stat-card .label { font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .stat-card .value { font-size: 2rem; font-weight: 700; color: #6366f1; }
        .main-grid { display: grid; grid-template-columns: 1fr 400px; gap: 1.5rem; }
        .panel { background: #1e293b; border: 1px solid #334155; border-radius: 0.75rem; overflow: hidden; }
        .panel-header { background: #0f172a; padding: 1rem 1.5rem; border-bottom: 1px solid #334155; display: flex; justify-content: space-between; align-items: center; }
        .panel-header h2 { font-size: 1rem; font-weight: 600; color: #f1f5f9; }
        .panel-body { padding: 1.5rem; }
        .tabs { display: flex; gap: 0.25rem; margin-bottom: 1.5rem; background: #0f172a; padding: 0.25rem; border-radius: 0.5rem; }
        .tab { padding: 0.5rem 1rem; border-radius: 0.4rem; font-size: 0.85rem; font-weight: 500; cursor: pointer; border: none; background: transparent; color: #94a3b8; transition: all 0.15s; }
        .tab.active { background: #6366f1; color: white; }
        .tab:hover:not(.active) { color: #e2e8f0; }
        .section { display: none; }
        .section.active { display: block; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.4rem; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem;
            color: #e2e8f0; padding: 0.6rem 0.75rem; font-size: 0.9rem; outline: none;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #6366f1; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
        .btn { padding: 0.6rem 1.25rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.15s; }
        .btn-primary { background: #6366f1; color: white; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.78rem; }
        .results { margin-top: 1.5rem; }
        .results h3 { font-size: 0.85rem; color: #94a3b8; margin-bottom: 0.75rem; }
        .result-list { display: flex; flex-direction: column; gap: 0.5rem; max-height: 300px; overflow-y: auto; }
        .result-item { background: #0f172a; border: 1px solid #1e293b; border-radius: 0.5rem; padding: 0.75rem; display: flex; justify-content: space-between; align-items: center; }
        .result-item .name { font-weight: 500; font-size: 0.9rem; }
        .result-item .meta { font-size: 0.75rem; color: #64748b; }
        .ws-panel { }
        .ws-status { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; }
        .ws-dot { width: 8px; height: 8px; border-radius: 50%; background: #ef4444; }
        .ws-dot.connected { background: #22c55e; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .ws-log { background: #0f172a; border: 1px solid #1e293b; border-radius: 0.5rem; height: 380px; overflow-y: auto; padding: 0.75rem; font-family: monospace; font-size: 0.8rem; }
        .ws-event { padding: 0.4rem 0.6rem; border-radius: 0.4rem; margin-bottom: 0.35rem; }
        .ws-event.created { background: rgba(34,197,94,0.1); border-left: 3px solid #22c55e; color: #86efac; }
        .ws-event.updated { background: rgba(234,179,8,0.1); border-left: 3px solid #eab308; color: #fde047; }
        .ws-event.deleted { background: rgba(239,68,68,0.1); border-left: 3px solid #ef4444; color: #fca5a5; }
        .ws-event.info { background: rgba(99,102,241,0.1); border-left: 3px solid #6366f1; color: #a5b4fc; }
        .ws-event .time { font-size: 0.7rem; opacity: 0.6; }
        .ws-placeholder { color: #475569; text-align: center; padding: 2rem; font-size: 0.85rem; }
        .response-box { background: #0f172a; border: 1px solid #1e293b; border-radius: 0.5rem; padding: 0.75rem; font-family: monospace; font-size: 0.75rem; max-height: 200px; overflow-y: auto; color: #a5b4fc; margin-top: 0.75rem; display: none; }
        .links { display: flex; gap: 0.75rem; margin-bottom: 1.5rem; }
        .link-btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #1e293b; border: 1px solid #334155; border-radius: 0.5rem; color: #e2e8f0; text-decoration: none; font-size: 0.85rem; transition: all 0.15s; }
        .link-btn:hover { border-color: #6366f1; color: #a5b4fc; }
        .empty { color: #475569; font-size: 0.85rem; text-align: center; padding: 1.5rem; }
    </style>
</head>
<body>

<div class="header">
    <h1>Laravel API Demo</h1>
    <span class="badge">REST + WebSockets</span>
</div>

<div class="container">

    <div class="links">
        <a href="/admin" class="link-btn">Admin Panel (Filament)</a>
        <a href="/request-docs" class="link-btn">API Documentation</a>
    </div>

    <div class="grid">
        <div class="stat-card">
            <div class="label">Users</div>
            <div class="value" id="stat-users">{{ $stats['users'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Categories</div>
            <div class="value" id="stat-categories">{{ $stats['categories'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Products</div>
            <div class="value" id="stat-products">{{ $stats['products'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Tags</div>
            <div class="value" id="stat-tags">{{ $stats['tags'] }}</div>
        </div>
    </div>

    <div class="main-grid">
        <div class="panel">
            <div class="panel-header">
                <h2>CRUD Operations</h2>
            </div>
            <div class="panel-body">
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('users')">Users</button>
                    <button class="tab" onclick="switchTab('categories')">Categories</button>
                    <button class="tab" onclick="switchTab('products')">Products</button>
                    <button class="tab" onclick="switchTab('tags')">Tags</button>
                </div>

                {{-- Users --}}
                <div class="section active" id="section-users">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="user-name" placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="user-email" placeholder="john@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="user-password" placeholder="min 8 characters">
                    </div>
                    <div style="display:flex;gap:0.5rem">
                        <button class="btn btn-primary" onclick="createUser()">Create User</button>
                        <button class="btn btn-primary" onclick="loadUsers()">Load Users</button>
                    </div>
                    <div class="response-box" id="user-response"></div>
                    <div class="results" id="users-list"></div>
                </div>

                {{-- Categories --}}
                <div class="section" id="section-categories">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="cat-name" placeholder="Electronics">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" id="cat-slug" placeholder="electronics">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="cat-description" rows="2" placeholder="Category description..."></textarea>
                    </div>
                    <div style="display:flex;gap:0.5rem">
                        <button class="btn btn-primary" onclick="createCategory()">Create Category</button>
                        <button class="btn btn-primary" onclick="loadCategories()">Load Categories</button>
                    </div>
                    <div class="response-box" id="cat-response"></div>
                    <div class="results" id="categories-list"></div>
                </div>

                {{-- Products --}}
                <div class="section" id="section-products">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="prod-name" placeholder="iPhone 15">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" id="prod-slug" placeholder="iphone-15">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Category ID</label>
                            <input type="number" id="prod-category" placeholder="1">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" id="prod-price" placeholder="999.99" step="0.01">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" id="prod-stock" placeholder="100">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="prod-status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem">
                        <button class="btn btn-primary" onclick="createProduct()">Create Product</button>
                        <button class="btn btn-primary" onclick="loadProducts()">Load Products</button>
                    </div>
                    <div class="response-box" id="prod-response"></div>
                    <div class="results" id="products-list"></div>
                </div>

                {{-- Tags --}}
                <div class="section" id="section-tags">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="tag-name" placeholder="Sale">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" id="tag-slug" placeholder="sale">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Color (hex)</label>
                        <input type="color" id="tag-color" value="#6366f1">
                    </div>
                    <div style="display:flex;gap:0.5rem">
                        <button class="btn btn-primary" onclick="createTag()">Create Tag</button>
                        <button class="btn btn-primary" onclick="loadTags()">Load Tags</button>
                    </div>
                    <div class="response-box" id="tag-response"></div>
                    <div class="results" id="tags-list"></div>
                </div>
            </div>
        </div>

        <div class="panel ws-panel">
            <div class="panel-header">
                <h2>WebSocket Events</h2>
                <div class="ws-status">
                    <div class="ws-dot" id="ws-dot"></div>
                    <span id="ws-status-text">Connecting...</span>
                </div>
            </div>
            <div class="panel-body" style="padding:1rem">
                <div class="ws-log" id="ws-log">
                    <div class="ws-placeholder">Waiting for events...<br>Perform any CRUD operation to see real-time updates here.</div>
                </div>
                <button class="btn btn-danger btn-sm" style="margin-top:0.75rem;width:100%" onclick="clearLog()">Clear Log</button>
            </div>
        </div>
    </div>
</div>

<script>
const api = window.axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    }
});

function switchTab(name) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    event.target.classList.add('active');
    document.getElementById('section-' + name).classList.add('active');
}

function showResponse(id, data) {
    const box = document.getElementById(id);
    box.style.display = 'block';
    box.textContent = JSON.stringify(data, null, 2);
}

function logEvent(type, message) {
    const log = document.getElementById('ws-log');
    const placeholder = log.querySelector('.ws-placeholder');
    if (placeholder) placeholder.remove();

    const div = document.createElement('div');
    div.className = 'ws-event ' + type;
    const now = new Date().toLocaleTimeString();
    div.innerHTML = `<div class="time">${now}</div>${message}`;
    log.prepend(div);
}

function clearLog() {
    document.getElementById('ws-log').innerHTML = '<div class="ws-placeholder">Log cleared. Waiting for events...</div>';
}

function updateStat(entity, delta) {
    const map = { user: 'users', category: 'categories', product: 'products', tag: 'tags' };
    const el = document.getElementById('stat-' + (map[entity] || entity));
    if (el) el.textContent = Math.max(0, parseInt(el.textContent) + delta);
}

// WebSocket
Echo.channel('entities')
    .listen('.entity.created', (e) => {
        logEvent('created', `<strong>[Created]</strong> ${e.entity} #${e.data.id} — <em>${e.data.name || e.data.email || ''}</em>`);
        updateStat(e.entity, 1);
    })
    .listen('.entity.updated', (e) => {
        logEvent('updated', `<strong>[Updated]</strong> ${e.entity} #${e.data.id} — <em>${e.data.name || e.data.email || ''}</em>`);
    })
    .listen('.entity.deleted', (e) => {
        logEvent('deleted', `<strong>[Deleted]</strong> ${e.entity} #${e.id}`);
        updateStat(e.entity, -1);
    });

Echo.connector.pusher.connection.bind('connected', () => {
    document.getElementById('ws-dot').classList.add('connected');
    document.getElementById('ws-status-text').textContent = 'Connected';
    logEvent('info', '<strong>[System]</strong> WebSocket connected to Reverb');
});
Echo.connector.pusher.connection.bind('disconnected', () => {
    document.getElementById('ws-dot').classList.remove('connected');
    document.getElementById('ws-status-text').textContent = 'Disconnected';
});

// Users
async function createUser() {
    try {
        const res = await api.post('/users', {
            name: document.getElementById('user-name').value,
            email: document.getElementById('user-email').value,
            password: document.getElementById('user-password').value,
        });
        showResponse('user-response', res.data);
    } catch(e) { showResponse('user-response', e.response?.data || e.message); }
}

async function loadUsers() {
    try {
        const res = await api.get('/users');
        const list = document.getElementById('users-list');
        list.innerHTML = '<h3>Users (' + res.data.total + ' total)</h3><div class="result-list">' +
            res.data.data.map(u => `<div class="result-item">
                <div><div class="name">${u.name}</div><div class="meta">${u.email}</div></div>
                <button class="btn btn-danger btn-sm" onclick="deleteUser(${u.id})">Delete</button>
            </div>`).join('') + '</div>';
    } catch(e) { showResponse('user-response', e.response?.data || e.message); }
}

async function deleteUser(id) {
    try {
        await api.delete('/users/' + id);
        loadUsers();
    } catch(e) { alert(e.response?.data?.message || e.message); }
}

// Categories
async function createCategory() {
    try {
        const res = await api.post('/categories', {
            name: document.getElementById('cat-name').value,
            slug: document.getElementById('cat-slug').value,
            description: document.getElementById('cat-description').value,
            is_active: true,
        });
        showResponse('cat-response', res.data);
    } catch(e) { showResponse('cat-response', e.response?.data || e.message); }
}

async function loadCategories() {
    try {
        const res = await api.get('/categories');
        const list = document.getElementById('categories-list');
        list.innerHTML = '<h3>Categories (' + res.data.total + ' total)</h3><div class="result-list">' +
            res.data.data.map(c => `<div class="result-item">
                <div><div class="name">${c.name}</div><div class="meta">${c.slug} · ${c.products_count ?? 0} products</div></div>
                <button class="btn btn-danger btn-sm" onclick="deleteCategory(${c.id})">Delete</button>
            </div>`).join('') + '</div>';
    } catch(e) { showResponse('cat-response', e.response?.data || e.message); }
}

async function deleteCategory(id) {
    try {
        await api.delete('/categories/' + id);
        loadCategories();
    } catch(e) { alert(e.response?.data?.message || e.message); }
}

// Products
async function createProduct() {
    try {
        const res = await api.post('/products', {
            category_id: parseInt(document.getElementById('prod-category').value),
            name: document.getElementById('prod-name').value,
            slug: document.getElementById('prod-slug').value,
            price: parseFloat(document.getElementById('prod-price').value),
            stock: parseInt(document.getElementById('prod-stock').value || 0),
            status: document.getElementById('prod-status').value,
        });
        showResponse('prod-response', res.data);
    } catch(e) { showResponse('prod-response', e.response?.data || e.message); }
}

async function loadProducts() {
    try {
        const res = await api.get('/products');
        const list = document.getElementById('products-list');
        list.innerHTML = '<h3>Products (' + res.data.total + ' total)</h3><div class="result-list">' +
            res.data.data.map(p => `<div class="result-item">
                <div><div class="name">${p.name}</div><div class="meta">$${p.price} · ${p.status}</div></div>
                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${p.id})">Delete</button>
            </div>`).join('') + '</div>';
    } catch(e) { showResponse('prod-response', e.response?.data || e.message); }
}

async function deleteProduct(id) {
    try {
        await api.delete('/products/' + id);
        loadProducts();
    } catch(e) { alert(e.response?.data?.message || e.message); }
}

// Tags
async function createTag() {
    try {
        const res = await api.post('/tags', {
            name: document.getElementById('tag-name').value,
            slug: document.getElementById('tag-slug').value,
            color: document.getElementById('tag-color').value,
        });
        showResponse('tag-response', res.data);
    } catch(e) { showResponse('tag-response', e.response?.data || e.message); }
}

async function loadTags() {
    try {
        const res = await api.get('/tags');
        const list = document.getElementById('tags-list');
        list.innerHTML = '<h3>Tags (' + res.data.total + ' total)</h3><div class="result-list">' +
            res.data.data.map(t => `<div class="result-item">
                <div style="display:flex;align-items:center;gap:0.5rem">
                    <span style="width:14px;height:14px;border-radius:50%;background:${t.color};display:inline-block"></span>
                    <div><div class="name">${t.name}</div><div class="meta">${t.slug}</div></div>
                </div>
                <button class="btn btn-danger btn-sm" onclick="deleteTag(${t.id})">Delete</button>
            </div>`).join('') + '</div>';
    } catch(e) { showResponse('tag-response', e.response?.data || e.message); }
}

async function deleteTag(id) {
    try {
        await api.delete('/tags/' + id);
        loadTags();
    } catch(e) { alert(e.response?.data?.message || e.message); }
}

// Auto-fill slugs
document.getElementById('cat-name').addEventListener('input', e => {
    document.getElementById('cat-slug').value = e.target.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
});
document.getElementById('prod-name').addEventListener('input', e => {
    document.getElementById('prod-slug').value = e.target.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
});
document.getElementById('tag-name').addEventListener('input', e => {
    document.getElementById('tag-slug').value = e.target.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
});
</script>

</body>
</html>
